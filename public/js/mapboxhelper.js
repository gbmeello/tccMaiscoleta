class MapBoxHelper {

    get mapboxgl() {
        return this._mapboxgl;
    }

    get map() {
        return this._map;
    }

    get draw() {
        return this._draw;
    }

    constructor(mapboxgl, map, draw) {
        this._mapboxgl = mapboxgl;
        this._map = map;
        this._draw = draw;
    }
}

function createPointMapDraw() {

    return new MapboxDraw({
        displayControlsDefault: false,
        controls: {
            point: true,
            trash: true
        },
        styles: [
            {
                'id': 'highlight-active-points',
                'type': 'circle',
                'filter': [
                    'all',
                    ['==', '$type', 'Point'],
                    ['==', 'meta', 'feature'],
                    ['==', 'active', 'true']
                ],
                'paint': {
                    'circle-radius': 7,
                    'circle-color': '#000000'
                }
            },
            {
                'id': 'points-are-blue',
                'type': 'circle',
                'filter': [
                    'all',
                    ['==', '$type', 'Point'],
                    ['==', 'meta', 'feature'],
                    ['==', 'active', 'false']
                ],
                'paint': {
                    'circle-radius': 5,
                    'circle-color': '#000088'
                }
            }
        ]
    });
}

/**
 * Cria uma instancia do MapDraw
 */
function createMapDraw() {
    return new MapboxDraw({
        displayControlsDefault: false,
        controls: {
            line_string: true,
            trash: true
        },
        styles: [
            // ACTIVE (being drawn)
            // line stroke
            {
                "id": "gl-draw-line",
                "type": "line",
                "filter": ["all", ["==", "$type", "LineString"], ["!=", "mode", "static"]],
                "layout": {
                    "line-cap": "round",
                    "line-join": "round"
                },
                "paint": {
                    "line-color": "#3b9ddd",
                    "line-dasharray": [0.2, 2],
                    "line-width": 4,
                    "line-opacity": 0.7
                }
            },
            // vertex point halos
            {
                "id": "gl-draw-polygon-and-line-vertex-halo-active",
                "type": "circle",
                "filter": ["all", ["==", "meta", "vertex"], ["==", "$type", "Point"], ["!=", "mode", "static"]],
                "paint": {
                    "circle-radius": 10,
                    "circle-color": "#FFF"
                }
            },
            // vertex points
            {
                "id": "gl-draw-polygon-and-line-vertex-active",
                "type": "circle",
                "filter": ["all", ["==", "meta", "vertex"], ["==", "$type", "Point"], ["!=", "mode", "static"]],
                "paint": {
                    "circle-radius": 6,
                    "circle-color": "#3b9ddd",
                }
            },
        ]
    });
}

function updatePoint() {

    removePoint(); // overwrite any existing layers
    let data = mapBoxHelper.draw.getAll();

    console.log(mapBoxHelper.draw);
    console.log(mapBoxHelper.draw.prototype);

    // let answer = $('#calculated-line');
    let lastFeature = data.features.length - 1;
    let coords = data.features[lastFeature].geometry.coordinates;

    // getMatch(urlCoords);

    addPoint(coords);

    mapBoxHelper.coordinatePontosColeta = coords;
}

/**
 * Atualiza a rota
 */
function updateRoute() {

    removeRoute(); // overwrite any existing layers
    let data = mapBoxHelper.draw.getAll();

    console.log(data);

    // let answer = $('#calculated-line');
    let lastFeature = data.features.length - 1;
    let coords = data.features[lastFeature].geometry.coordinates;
    let urlCoords = coords.join(';');

    getMatch(urlCoords);

    mapBoxHelper.coordinatePontosColeta = coords;
}

/**
 * Faz a requisição do cálculo das direções
 * @param {*} coords Coordenadas separadas por ponto e vírgula
 * @param {*} mapboxgl Instancia do MapboxGL
 */
function getMatch(urlCoords) {

    let url = 'https://api.mapbox.com/directions/v5/mapbox/driving/' + urlCoords +'?geometries=geojson&steps=true&&access_token=' + mapBoxHelper.mapboxgl.accessToken;

    let req = new XMLHttpRequest();
    req.responseType = 'json';
    req.open('GET', url, true);
    req.onload = function() {

        let jsonResponse = req.response;
        let distance = jsonResponse.routes[0].distance * 0.001;
        let duration = jsonResponse.routes[0].duration / 60;

        let text = `
            Distancia: ${distance.toFixed(2)} km
            <br>
            Estimativa de tempo: ${duration.toFixed(2)} minutos`;

        $('#calculated-line').html(text);

        let coords = jsonResponse.routes[0].geometry;

        addRoute(coords);
    };
    req.send();
}

/**
 * Adiciona rota no mapa
 * @param {*} coords Coordenadas
 * @param {*} map Objeto mapa do Mapbox
 */
function addRoute (coords) {

    console.log('Route geometry');
    console.log(coords);

    let map = mapBoxHelper.map;
    //checa se já existe
    if (map.getSource('route')) {

        map.removeLayer('route')
        map.removeSource('route')

    } else {
        map.addLayer({
            "id": "route",
            "type": "line",
            "source": {
                "type": "geojson",
                "data": {
                    "type": "Feature",
                    "properties": {},
                    "geometry": coords
                }
            },
            "layout": {
                "line-join": "round",
                "line-cap": "round"
            },
            "paint": {
                "line-color": "#3b9ddd",
                "line-width": 8,
                "line-opacity": 0.8
            }
        });
    }
}

/**
 * Adiciona rota no mapa
 * @param {*} coords Coordenadas
 * @param {*} map Objeto mapa do Mapbox
 */
function addPoint (coords) {

    console.log('Point geometry');
    console.log(coords);

    let map = mapBoxHelper.map;
    //checa se já existe
    if (map.getSource('point')) {

        map.removeLayer('point')
        map.removeSource('point')

    } else {
        map.addLayer({
            "id": guid(),
            "type": "circle",
            "source": {
                "type": "geojson",
                "data": {
                    "type": "FeatureCollection",
                    "features": [{
                        "type": "Feature",
                        "geometry": {
                            "type": "Point",
                            "coordinates": [coords[0], coords[1]]
                        }
                    }]
                }
            },
            "paint": {
                "circle-radius": 6,
                "circle-color": "#3b9ddd",
            }
        });
    }
}

/**
 * Remove rota do mapa, se existir
 */
function removeRoute () {
    debugger;
    let map = mapBoxHelper.map;
    if (map.getSource('route')) {
        map.removeLayer('route');
        map.removeSource('route');
        $('#calculated-line').empty();
        mapBoxHelper.coordinatePontosColeta = [];
    } else  {
        return;
    }
}


/**
 * Remove ponto do mapa, se existir
 */
function removePoint () {
    debugger;
    let map = mapBoxHelper.map;
    if (map.getSource('point')) {
        map.removeLayer('point');
        map.removeSource('point');
        $('#calculated-line').empty();
        mapBoxHelper.coordinatePontosColeta = [];
    } else  {
        return;
    }
}


/**
 * Inicia o mapa com a plotagem do ponto de coleta
 */
function initializeMapModal(id) {

    bootbox.dialog({
        title: '<strong>Visualizar Ponto de Coleta Mapa</strong>',
        message: '<div id="map" style="width: 100%; height: 500px"></div>',
        confirm: {
            className: 'btn-danger'
        }
    });

    debugger;

    $.get(
        '/api/v1/ponto-coleta/exibir/' + id,
        function(response) {

            if(! response.success) {
                bootbox.dialog({
                    title: '<strong>Atenção</strong>',
                    message: response.message,
                    confirm: {
                        className: 'btn-primary'
                    }
                });
                return;
            }

            mapboxgl.accessToken = 'pk.eyJ1IjoibWFyY2lvbWVuZGVzIiwiYSI6ImNqc2VtNGtmeTBzNGQzeXRscWxkMThvcXIifQ.83J82VEpsdmfE-xu9W4uUg';
            var map = new mapboxgl.Map({
                container: 'map', // container id
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [-42.025932, -22.972347], // starting position
                zoom: 12 // starting zoom
            });

            mapBoxHelper = new MapBoxHelper(mapboxgl, map);

            map.addControl(new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                zoom: 14,
                placeholder: "Rua, Bairro, Endereço etc...",
                mapboxgl: mapboxgl
            }));

            // map.addControl(mapBoxHelper.draw);

            // let mapboxCtrlGroup = $('.mapboxgl-ctrl-group');
            // mapboxCtrlGroup.find('.mapbox-gl-draw_line').attr('title', 'Desenhe a rota desejada');
            // mapboxCtrlGroup.find('.mapbox-gl-draw_trash').attr('title', 'Remova a rota desejada');

            // Add geolocate control to the map.
            map.addControl(new mapboxgl.GeolocateControl({
                positionOptions: {
                    enableHighAccuracy: true
                },
                trackUserLocation: true
            }));

            var popup = new mapboxgl.Popup({
                closeButton: true,
                closeOnClick: true
            });


            map.loadImage('/img/truck-mark.png', function(error, image) {

                if(error) {
                    throw error;
                }

                map.on('mouseenter', response.data.nome, function (e) {

                    var coordinates = e.features[0].geometry.coordinates.slice();
                    var description = e.features[0].properties.description;

                    // Ensure that if the map is zoomed out such that multiple
                    // copies of the feature are visible, the popup appears
                    // over the copy being pointed to.
                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }

                    // Populate the popup and set its coordinates
                    // based on the feature found.
                    popup.setLngLat(coordinates)
                    .setHTML(description)
                    .addTo(map);
                });

                if (! map.getLayer(response.data.nome)) {

                    map.addImage(response.data.nome, image);
                    map.addLayer({
                        "id": response.data.nome,
                        "type": "symbol",
                        "source": {
                            "type": "geojson",
                            "data": {
                                "type": "FeatureCollection",
                                "features": [{
                                    "type": "Feature",
                                    "properties": {
                                        "description": "<p><strong>Ponto de Coleta - ["+ response.data.nome +"]</strong></p><p>"+ response.data.descricao +"</p>",
                                        "icon": "marker",
                                        "size": 15
                                    },
                                    "geometry": {
                                        "type": "Point",
                                        "coordinates": [response.data.longitude, response.data.latitude]
                                    }
                                }]
                            }
                        },
                        "layout": {
                            "icon-image": response.data.nome,
                            "icon-size": 0.15
                        }
                    });
                }
            });
        }
    );


}