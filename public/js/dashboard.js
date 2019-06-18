class DashboardChart {

    setSettings(value) {
        this.settings = value;
    }

    setChart(value) {
        this.chart = value;
    }

    get getSettings() {
        return this.settings;
    }

    get getChart() {
        return this.chart;
    }

    constructor(settings = null) {
        this.init(settings);
        this.config();
        this.registerDefaultsEvents();
        this.registerEvents();
        this.initChart();
    }

    registerDefaultsEvents() {
        Chart.plugins.register({
            afterDraw: function(chart) {
                //debugger;
                if (chart.data.datasets[0].data.length === 0) {
                    let ctx = chart.chart.ctx,
                        width = chart.chart.width,
                        height = chart.chart.height;
                    chart.clear();

                    ctx.save();
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    ctx.font = "20px normal 'Helvetica Nueue'";
                    ctx.fillText('Não há nenhum dado a ser exibido', width / 2, height / 2);
                    ctx.restore();
                }
            }
        });
    }

    init(settings) {
        if(settings !== null) {
            this.setSettings(settings);
        } else {
            this.setSettings(DashboardChart.prototype.getDefaultsSettings());
        }
    }

    /**
     * Registra novos eventos
     * */
    registerEvents() {
    }

    /**
     * Método responsável pelo controle das configurações customizadas
     * */
    config() {
    }

    /**
     * Método de inicialização
     * */
    initChart() {
    }

    /**
     * Configuração padrão para todos os gráficos
     * */
    getDefaultsSettings() {
        let defaults = {
            content: [],
            canvas: null,
            chart: {
                obj: null,
                dataset: {
                    labels: [],
                    values: [],
                    colors: []
                },
                scales: {
                    yAxes: true,
                    xAxes: true,
                },
                name: '',
                label: '',
                title: '',
                type: '',
            },
            tableLabelColumnText: 'Dados',
            tableValueColumnText: 'Quant.',
            showTable: true
        };
        return defaults;
    }

    /**
     * Inicia a tabela com os dados
     * */
    initTable() {

        let idTargetCanvas = this.getChart.chart.canvas.id,
            data = this.getChart.data,
            labels = data.labels,
            datasets = data.datasets,
            tam = labels.length,
            html = null;

        if(tam > 0) {

            html =
                `<table id="table-${idTargetCanvas}" class="table table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        <th style="width: 120px;">#</th>
                        <th>${this.getSettings.tableLabelColumnText}</th>
                        <th>${this.getSettings.tableValueColumnText}</th>
                        <th>Cor</th>
                    </tr>
                </thead>
                <tbody>`;

            for(let i = 0; i < tam; i++) {

                let lbl = labels[i] != undefined ? labels[i] : '-';
                let val = datasets[0].data[i] != undefined ? datasets[0].data[i] : 0;
                let color = datasets[0].backgroundColor[i];

                html += `<tr>
                            <td>${i + 1}&deg;</td>
                            <td>${lbl}</td>
                            <td>${val}</td>
                            <td style="width: 40px; background-color: ${color}"></td>
                        </tr>`;
            }

            html += '</tbody></table>';

        } else {

            html = `<div class="callout callout-info">
                        <h4><i class="fa fa-info-circle"></i> Sem informação</h4>            
                        <p>Não foi encontrada nenhuma informação referente a este dado</p>
                    </div>`;
        }

        let title = this.getSettings.chart.title;
        let $button = $('#'+idTargetCanvas).closest('.box').find('button');

        $button.click(function () {
            bootstrapModal.buildVisualizarModal(title, html);
        });

        $button.before(
            `<a href="javascript:;" title="Download da tabela" style="margin-right:5px;" 
                class="btn bg-blue btn-flat btn-sm btn-download-table">
               <i class="fa fa-download"></i></a>`);

        $button.siblings('.btn-download-table').click(function() {
            if(tam > 0) {
                if (confirm("Você deseja fazer o download da tabela?")) {
                    DashboardChart.prototype.initDownload(title, html);
                }
            } else {
                alert('Não há dados para serem baixados');
            }
        });

        return html;
    }

    /**
     * Prepara a tabela para download e em formato do excel
     * */
    initDownload(title, html) {
        // window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html), title + '.xls');
        let encodedUri = 'data:application/vnd.ms-excel,' + encodeURIComponent(html);
        let link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", title + '.xls');
        document.body.appendChild(link); // Required for FF
        link.click();
        document.body.removeChild(link);
    }
}


class MyEmptyChart extends DashboardChart {

    constructor(settings) {
        super(settings);
    }

    initChart() {
        let defaults = DashboardChart.prototype.getDefaultsSettings();
        defaults.canvas = this.getSettings.canvas;
        defaults.canvas = this.chart.type;
        this.setChart(new Chart(defaults));
    }
}


class MyPieChart extends DashboardChart {

    constructor(settings) {
        super(settings);
    }

    config() {
        this.getSettings.chart.scales.yAxes = false;
        this.getSettings.chart.scales.xAxes = false;
    }

    initChart() {
        this.getSettings.chart.dataset.colors = (ColorsHelper.prototype.getDynamicColors(this.getSettings.chart.dataset.labels.length));
        this.setChart(
            new Chart(this.getSettings.canvas, {
                type: this.getSettings.chart.type,
                data: {
                    labels: this.getSettings.chart.dataset.labels,
                    datasets: [{
                        label: this.getSettings.chart.label,
                        data: this.getSettings.chart.dataset.values,
                        backgroundColor: this.getSettings.chart.dataset.colors,
                        borderColor: this.getSettings.chart.dataset.colors,
                        hoverBackgroundColor: this.getSettings.chart.dataset.colors
                    }]
                },
                options: {
                    segmentShowStroke: true,
                    segmentStrokeColor: '#fff',
                    segmentStrokeWidth: 2,
                    //Number - Amount of animation steps
                    animationSteps       : 100,
                    //String - Animation easing effect
                    animationEasing      : 'easeOutBounce',
                    //Boolean - Whether we animate the rotation of the Doughnut
                    animateRotate        : true,
                    //Boolean - Whether we animate scaling the Doughnut from the centre
                    animateScale         : false,
                    //Boolean - whether to make the chart responsive to window resizing
                    responsive           : true,
                    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                    maintainAspectRatio  : true,
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            display: this.getSettings.chart.scales.yAxes
                        }],
                        xAxes: [{
                            display: this.getSettings.chart.scales.xAxes
                        }]
                    },
                    title: {
                        display: true,
                        text: this.getSettings.chart.title
                    }
                }
            })
        );
    }
}


class MyBarChart extends DashboardChart {

    constructor(settings) {
        super(settings);
    }

    config() {
        this.getSettings.chart.scales.yAxes = true;
        this.getSettings.chart.scales.xAxes = true;
    }

    initChart() {
        this.getSettings.chart.dataset.colors = (ColorsHelper.prototype.getDynamicColors(this.getSettings.chart.dataset.labels.length));
        this.setChart(
            new Chart(this.getSettings.canvas, {
                type: this.getSettings.chart.type,
                data: {
                    labels: this.getSettings.chart.dataset.labels,
                    datasets: [{
                        label: this.getSettings.chart.label,
                        data: this.getSettings.chart.dataset.values,
                        backgroundColor: this.getSettings.chart.dataset.colors,
                        borderColor: this.getSettings.chart.dataset.colors,
                        hoverBackgroundColor: this.getSettings.chart.dataset.colors
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            display: this.getSettings.chart.scales.yAxes
                        }],
                        xAxes: [{
                            display: this.getSettings.chart.scales.xAxes
                        }]
                    },
                    title: {
                        display: true,
                        text: this.getSettings.chart.title
                    }
                }
            })
        );
    }
}


class MyHorizontalBarChart extends DashboardChart {

    constructor(settings) {
        super(settings);
    }

    config() {
        this.getSettings.chart.scales.yAxes = true;
        this.getSettings.chart.scales.xAxes = true;
    }

    initChart() {
        this.getSettings.chart.dataset.colors = (ColorsHelper.prototype.getDynamicColors(this.getSettings.chart.dataset.labels.length));
        this.setChart(
            new Chart(this.getSettings.canvas, {
                type: this.getSettings.chart.type,
                data: {
                    labels: this.getSettings.chart.dataset.labels,
                    datasets: [{
                        label: this.getSettings.chart.label,
                        data: this.getSettings.chart.dataset.values,
                        backgroundColor: this.getSettings.chart.dataset.colors,
                        borderColor: this.getSettings.chart.dataset.colors,
                        hoverBackgroundColor: this.getSettings.chart.dataset.colors
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            display: this.getSettings.chart.scales.yAxes
                        }],
                        xAxes: [{
                            display: this.getSettings.chart.scales.xAxes
                        }]
                    },
                    title: {
                        display: true,
                        text: this.getSettings.chart.title
                    }
                }
            })
        );
    }
}


$.fn.createCanvas = function createCanvas(id, cssClass) {

    let $newCanvas = $('<canvas/>', {
        'id': id,
        'name': id,
        'class': cssClass
    });

    $(this).append($newCanvas);

    return $newCanvas;
};


$.fn.chartbox = function(options) {

    let defaults = DashboardChart.prototype.getDefaultsSettings();
    let settings = $.extend(true, defaults, options);
    let $this = $(this);

    if(StringHelper.prototype.isEmpty($this.get(0))) {

        console.error('You need create a canvas element');

    } else {

        settings.chart.obj      = $this;
        settings.canvas         = $this.get(0).getContext('2d');
        settings.chart.name     = getValue($this.data('chart-name'), settings.chart.name);
        settings.chart.label    = getValue($this.data('chart-label'), settings.chart.label);
        settings.chart.title    = getValue($this.data('chart-title'), settings.chart.title);
        settings.tableLabelColumnText   = getValue($this.data('table-label-column'), settings.tableLabelColumnText);
        settings.tableValueColumnText   = getValue($this.data('table-value-column'), settings.tableValueColumnText);

        // var chart = null;
        //debugger;
        if(Object.keys(settings.content).length >= 1) {
            if(!StringHelper.prototype.isEmpty(settings.content[0])) {
                if('label' in settings.content[0] && 'value' in settings.content[0]) {
                    initializeChartbox(settings);
                }
                else {
                    $.each(settings.content, function (i, v) {
                        if(settings.chart.name in v) {
                            settings.content = v[settings.chart.name];
                            initializeChartbox(settings.content);
                        }
                    });
                }
            } else if(!StringHelper.prototype.isEmpty(settings.chart) && settings.chart.name in settings.content) {
                settings.content = settings.content[settings.chart.name];
                initializeChartbox(settings);
            }
        } else {
            initializeChartbox(settings);
        }

    }

};

function initializeChartbox(settings = null) {

    var chart = null;

    settings.chart.dataset.labels = pluck(settings.content, 'label');
    settings.chart.dataset.values = pluck(settings.content, 'value');

    switch (settings.chart.type) {
        case 'pie':
            chart = new MyPieChart(settings);
            break;
        case 'bar':
            chart = new MyBarChart(settings);
            break;
        case 'horizontalBar':
            chart = new MyHorizontalBarChart(settings);
            break;
        default:
            alert('esse chart type não existe');
            break;
    }

    if(settings.showTable && chart !== null) {
        chart.initTable();
    }



    return chart;
}


function getValue(data1, data2) {
    if(data1 === undefined) {
        return data2;
    }
    return data1;
}


/**
 * Retorna o HSL
 * @link https://stackoverflow.com/a/25873123
 * */
function randomHsl() {
    return 'hsla(' + Math.floor(Math.random() * 360) + ', 100%, 70%, 1)';
}


class ColorsHelper {

    /**
     * colors from https://github.com/egoist/color-lib/blob/master/color.json
     * */
    materialColor() {
        var colors = {
            "red": {
                ////"50": "#ffebee",
                "100": "#ffcdd2",
                "200": "#ef9a9a",
                "300": "#e57373",
                "400": "#ef5350",
                "500": "#f44336",
                "600": "#e53935",
                "700": "#d32f2f",
                "800": "#c62828",
                "900": "#b71c1c",
                "hex": "#f44336",
                "a100": "#ff8a80",
                "a200": "#ff5252",
                "a400": "#ff1744",
                "a700": "#d50000"
            },
            "pink": {
                ////"50": "#fce4ec",
                "100": "#f8bbd0",
                "200": "#f48fb1",
                "300": "#f06292",
                "400": "#ec407a",
                "500": "#e91e63",
                "600": "#d81b60",
                "700": "#c2185b",
                "800": "#ad1457",
                "900": "#880e4f",
                "hex": "#e91e63",
                "a100": "#ff80ab",
                "a200": "#ff4081",
                "a400": "#f50057",
                "a700": "#c51162"
            },
            "purple": {
                ////"50": "#f3e5f5",
                "100": "#e1bee7",
                "200": "#ce93d8",
                "300": "#ba68c8",
                "400": "#ab47bc",
                "500": "#9c27b0",
                "600": "#8e24aa",
                "700": "#7b1fa2",
                "800": "#6a1b9a",
                "900": "#4a148c",
                "hex": "#9c27b0",
                "a100": "#ea80fc",
                "a200": "#e040fb",
                "a400": "#d500f9",
                "a700": "#aa00ff"
            },
            "deepPurple": {
                //"50": "#ede7f6",
                "100": "#d1c4e9",
                "200": "#b39ddb",
                "300": "#9575cd",
                "400": "#7e57c2",
                "500": "#673ab7",
                "600": "#5e35b1",
                "700": "#512da8",
                "800": "#4527a0",
                "900": "#311b92",
                "hex": "#673ab7",
                "a100": "#b388ff",
                "a200": "#7c4dff",
                "a400": "#651fff",
                "a700": "#6200ea"
            },
            "indigo": {
                //"50": "#e8eaf6",
                "100": "#c5cae9",
                "200": "#9fa8da",
                "300": "#7986cb",
                "400": "#5c6bc0",
                "500": "#3f51b5",
                "600": "#3949ab",
                "700": "#303f9f",
                "800": "#283593",
                "900": "#1a237e",
                "hex": "#3f51b5",
                "a100": "#8c9eff",
                "a200": "#536dfe",
                "a400": "#3d5afe",
                "a700": "#304ffe"
            },
            "blue": {
                //"50": "#e3f2fd",
                "100": "#bbdefb",
                "200": "#90caf9",
                "300": "#64b5f6",
                "400": "#42a5f5",
                "500": "#2196f3",
                "600": "#1e88e5",
                "700": "#1976d2",
                "800": "#1565c0",
                "900": "#0d47a1",
                "hex": "#2196f3",
                "a100": "#82b1ff",
                "a200": "#448aff",
                "a400": "#2979ff",
                "a700": "#2962ff"
            },
            "lightBlue": {
                //"50": "#e1f5fe",
                "100": "#b3e5fc",
                "200": "#81d4fa",
                "300": "#4fc3f7",
                "400": "#29b6f6",
                "500": "#03a9f4",
                "600": "#039be5",
                "700": "#0288d1",
                "800": "#0277bd",
                "900": "#01579b",
                "hex": "#03a9f4",
                "a100": "#80d8ff",
                "a200": "#40c4ff",
                "a400": "#00b0ff",
                "a700": "#0091ea"
            },
            "cyan": {
                //"50": "#e0f7fa",
                "100": "#b2ebf2",
                "200": "#80deea",
                "300": "#4dd0e1",
                "400": "#26c6da",
                "500": "#00bcd4",
                "600": "#00acc1",
                "700": "#0097a7",
                "800": "#00838f",
                "900": "#006064",
                "hex": "#00bcd4",
                "a100": "#84ffff",
                "a200": "#18ffff",
                "a400": "#00e5ff",
                "a700": "#00b8d4"
            },
            "teal": {
                //"50": "#e0f2f1",
                "100": "#b2dfdb",
                "200": "#80cbc4",
                "300": "#4db6ac",
                "400": "#26a69a",
                "500": "#009688",
                "600": "#00897b",
                "700": "#00796b",
                "800": "#00695c",
                "900": "#004d40",
                "hex": "#009688",
                "a100": "#a7ffeb",
                "a200": "#64ffda",
                "a400": "#1de9b6",
                "a700": "#00bfa5"
            },
            "green": {
                //"50": "#e8f5e9",
                "100": "#c8e6c9",
                "200": "#a5d6a7",
                "300": "#81c784",
                "400": "#66bb6a",
                "500": "#4caf50",
                "600": "#43a047",
                "700": "#388e3c",
                "800": "#2e7d32",
                "900": "#1b5e20",
                "hex": "#4caf50",
                "a100": "#b9f6ca",
                "a200": "#69f0ae",
                "a400": "#00e676",
                "a700": "#00c853"
            },
            "lightGreen": {
                //"50": "#f1f8e9",
                "100": "#dcedc8",
                "200": "#c5e1a5",
                "300": "#aed581",
                "400": "#9ccc65",
                "500": "#8bc34a",
                "600": "#7cb342",
                "700": "#689f38",
                "800": "#558b2f",
                "900": "#33691e",
                "hex": "#8bc34a",
                "a100": "#ccff90",
                "a200": "#b2ff59",
                "a400": "#76ff03",
                "a700": "#64dd17"
            },
            "lime": {
                //"50": "#f9fbe7",
                "100": "#f0f4c3",
                "200": "#e6ee9c",
                "300": "#dce775",
                "400": "#d4e157",
                "500": "#cddc39",
                "600": "#c0ca33",
                "700": "#afb42b",
                "800": "#9e9d24",
                "900": "#827717",
                "hex": "#cddc39",
                "a100": "#f4ff81",
                "a200": "#eeff41",
                "a400": "#c6ff00",
                "a700": "#aeea00"
            },
            "yellow": {
                //"50": "#fffde7",
                "100": "#fff9c4",
                "200": "#fff59d",
                "300": "#fff176",
                "400": "#ffee58",
                "500": "#ffeb3b",
                "600": "#fdd835",
                "700": "#fbc02d",
                "800": "#f9a825",
                "900": "#f57f17",
                "hex": "#ffeb3b",
                "a100": "#ffff8d",
                "a200": "#ffff00",
                "a400": "#ffea00",
                "a700": "#ffd600"
            },
            "amber": {
                //"50": "#fff8e1",
                "100": "#ffecb3",
                "200": "#ffe082",
                "300": "#ffd54f",
                "400": "#ffca28",
                "500": "#ffc107",
                "600": "#ffb300",
                "700": "#ffa000",
                "800": "#ff8f00",
                "900": "#ff6f00",
                "hex": "#ffc107",
                "a100": "#ffe57f",
                "a200": "#ffd740",
                "a400": "#ffc400",
                "a700": "#ffab00"
            },
            "orange": {
                //"50": "#fff3e0",
                "100": "#ffe0b2",
                "200": "#ffcc80",
                "300": "#ffb74d",
                "400": "#ffa726",
                "500": "#ff9800",
                "600": "#fb8c00",
                "700": "#f57c00",
                "800": "#ef6c00",
                "900": "#e65100",
                "hex": "#ff9800",
                "a100": "#ffd180",
                "a200": "#ffab40",
                "a400": "#ff9100",
                "a700": "#ff6d00"
            },
            "deepOrange": {
                //"50": "#fbe9e7",
                "100": "#ffccbc",
                "200": "#ffab91",
                "300": "#ff8a65",
                "400": "#ff7043",
                "500": "#ff5722",
                "600": "#f4511e",
                "700": "#e64a19",
                "800": "#d84315",
                "900": "#bf360c",
                "hex": "#ff5722",
                "a100": "#ff9e80",
                "a200": "#ff6e40",
                "a400": "#ff3d00",
                "a700": "#dd2c00"
            },
            "brown": {
                //"50": "#efebe9",
                "100": "#d7ccc8",
                "200": "#bcaaa4",
                "300": "#a1887f",
                "400": "#8d6e63",
                "500": "#795548",
                "600": "#6d4c41",
                "700": "#5d4037",
                "800": "#4e342e",
                "900": "#3e2723",
                "hex": "#795548"
            },
            "grey": {
                //"50": "#fafafa",
                //"100": "#f5f5f5",
                //"200": "#eeeeee",
                //"300": "#e0e0e0",
                "400": "#bdbdbd",
                "500": "#9e9e9e",
                "600": "#757575",
                "700": "#616161",
                "800": "#424242",
                "900": "#212121",
                "hex": "#9e9e9e"
            },
            "blueGrey": {
                //"50": "#eceff1",
                //"100": "#cfd8dc",
                "200": "#b0bec5",
                "300": "#90a4ae",
                "400": "#78909c",
                "500": "#607d8b",
                "600": "#546e7a",
                "700": "#455a64",
                "800": "#37474f",
                "900": "#263238",
                "hex": "#607d8b"
            },
            "black": {
                "hex": "#000000"
            },
            // "white": {
            //     "hex": "#ffffff"
            // }
        }
        // pick random property
        //var property = pickRandomProperty(colors);
        let colorList = colors[this.pickRandomProperty(colors)];
        let newColorKey = this.pickRandomProperty(colorList);
        let newColor = colorList[newColorKey];
        return newColor;
    }


    pickRandomProperty(obj) {
        let result;
        let count = 0;
        for (let prop in obj)
            if (Math.random() < 1 / ++count)
                result = prop;
        return result;
    }


    /**
     * Retorna cores aleatoriamente, evitando cores parecidas
     * @param int Quantidade de cores a serem retornadas
     * @return array Array com as cores populadas
     * */
    getDynamicColors(qtd) {
        let colorsArray = [];
        for(let i = 0; i < qtd; i++) {

            let color = this.materialColor();

            for(let j = 0; j < colorsArray.length; j++) {

                if(colorsArray[j] == color) {
                    color = this.materialColor();
                    j = 0;//restart n' verify again
                }

            }

            colorsArray.push(color);
        }
        return colorsArray;
    }

}

/**
 * Retorna todos os valores relacionados a key passada
 * @param array Array alvo
 * @param string Key alvo
 * */
function pluck(array, key) {
    let newArray = [];
    if(array.length > 0) {
        newArray = array.map(o => o[key]);
    }
    return newArray;
}

/**
 * Retorna Guid
 * @return string Guid com valores aleatórios
 * */
function getGuid() {
    return Math.random().toString(36).replace(/[^a-z]+/g, '').substr(2, 10);
}



class StringHelper {

    isEmpty(str) {
        return (!str || 0 === str.length);
    }

};


var idInfobox = 1;
/**
 * Cria um infobox dentro do elemento atual que chama a função
 * @param string Texto exibido no corpo
 * @param int Valor exibido no corpo
 * @param string Classe de cor exibida no ícone
 * @param string Classe do ícone
 * */
$.fn.appendInfobox = function(text, number, classColor, classIcon) {

    let div = `
        <div class="col-md-4 col-sm-6 col-xs-12" title="${text}">
            <div id="infobox-${idInfobox++}" class="info-box">
                <span class="info-box-icon ${classColor}"><i class="fa ${classIcon}"></i></span>    
                <div class="info-box-content">
                    <span class="info-box-text">${text}</span>
                    <span class="info-box-number">${number}</span>
                </div>
            </div>
        </div>`;

    let $this = $(this);
    $this.append(div);

    return $this;
};


var idSmallbox = 1;
/**
 * Cria um smallbox dentro do elemento atual que chama a função
 * @param string Texto exibido no corpo
 * @param int Valor exibido no corpo
 * @param string Classe de cor exibida no ícone
 * @param string Classe do ícone
 * */
$.fn.appendSmallbox = function(classColor, classIcon, object, text = null, number = null) {

    let id = `smallbox-${idSmallbox++}`,
        btnId = `btn-${id}-modal`;

    //debugger;

    if(StringHelper.prototype.isEmpty(text) && StringHelper.prototype.isEmpty(object.text))
        text = 'Dados';
    else if(!StringHelper.prototype.isEmpty(object.text))
        text = object.text;

    //debugger;

    if(StringHelper.prototype.isEmpty(object.tableModel) || StringHelper.prototype.isEmpty(object.tableModel.body))
        number = 0;
    else
        number = (number === null ? Object.keys(object.tableModel.body).length : 0);

    initBox = function() {
        let div = `
        <div class="col-lg-3 col-md-6 col-xs-6">
            <div id="${id}" class="small-box ${classColor}">
                <div class="inner">
                    <h3>${number}</h3>                
                    <span class="small-box-title">${text}</span>
                </div>
                <div class="icon">
                    <i class="fa ${classIcon}"></i>
                </div>
                <a href="javascript:0;" id="${btnId}" class="small-box-footer small-box-info-button">
                    Mais informações <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>`;
        return div;
    };

    initTableModel = function(obj) {

        if(StringHelper.prototype.isEmpty(obj.tableModel)) {
            alert('Não existe nenhum dado para ser exibido');
            return;
        }

        //debugger;
        let header = obj.tableModel.header,
            body = obj.tableModel.body;

        let titleRow = '';
        $.each(header, function(index, value) {
            titleRow += `<th>${value}</th>`;
        });

        let html = `        
            <table id="table-${id}" class="table table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        ${titleRow}
                    </tr>
                </thead>
                <tbody>`;


        let bodyRows = '';
        $.each(body, function(index, value) {
            let cell = '';
            $.each(header, function (headerIndex, headerValue) {
                cell += `<td>${value[headerValue]}</td>`;
            });
            bodyRows += `<tr>${cell}</tr>`;
        });

        bodyRows += '</tbody></table>';
        html += bodyRows;

        bootstrapModal.buildVisualizarModal(text, html, 'modal-lg');

    };

    let $this = $(this);
    $this.append(initBox());

    // console.log($this.find('#' + btnId));

    $this.find('#' + btnId).unbind('click').click(function () {
        initTableModel(object);
    });

    return $this;
};

/**
 * Cria um smallbox dentro do elemento atual que chama a função
 * @param string Texto exibido no corpo
 * @param int Valor exibido no corpo
 * @param string Classe de cor exibida no ícone
 * @param string Classe do ícone
 * */
$.fn.populateSmallbox = function(object) {

    idSmallbox++;

    let $target = this,
        $btn = $target.find('.small-box-info-button');

    let $smallboxNumber = $target.find('.small-box-number');
    let $smallboxTitle = $target.find('.small-box-title');

    if(StringHelper.prototype.isEmpty($smallboxTitle.html()) && StringHelper.prototype.isEmpty(object.text))
        $smallboxTitle.html('Dados');
    else if(! StringHelper.prototype.isEmpty(object.text))
        $smallboxTitle.html(object.text);

    if(StringHelper.prototype.isEmpty($smallboxNumber.html()) && StringHelper.prototype.isEmpty(object.tableModel))
        $smallboxNumber.html(0);
    else if(! StringHelper.prototype.isEmpty(object.tableModel) && Object.keys(object.tableModel.body).length)
        $smallboxNumber.html(Object.keys(object.tableModel.body).length);

    initTableModel = function(obj) {

        let header = obj.tableModel.header,
            body = obj.tableModel.body;

        let titleRow = '';
        $.each(header, function(index, value) {
            titleRow += `<th>${value}</th>`;
        });

        let html = `        
            <table id="table-smallbox-${idSmallbox}" class="table table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        ${titleRow}
                    </tr>
                </thead>
                <tbody>`;


        let bodyRows = '';
        $.each(body, function(index, value) {
            let cell = '';
            $.each(header, function (headerIndex, headerValue) {
                cell += `<td>${value[headerValue]}</td>`;
            });
            bodyRows += `<tr>${cell}</tr>`;
        });

        bodyRows += '</tbody></table>';
        html += bodyRows;

        bootstrapModal.buildVisualizarModal(obj.text, html, 'modal-lg');

        return html;
    };

    if(!StringHelper.prototype.isEmpty(object.tableModel)) {

        $btn.unbind('click').click(function () {

            if(StringHelper.prototype.isEmpty(object.tableModel)) {
                alert('Não existe nenhum dado para ser exibido');
                return;
            }

            let html = initTableModel(object);

            let $body = $('body');
            let $button = $body.find('.modal-footer').find('button');

            $button.before(
                `<a href="javascript:;" title="Download da tabela" class="btn bg-blue btn-flat btn-sm btn-download-table pull-left">
                    <i class="fa fa-download"> Download</i>
                </a>`);

            $button.siblings('.btn-download-table').click(function() {
                if(! StringHelper.prototype.isEmpty(object.tableModel)) {
                    if (confirm("Você deseja fazer o download da tabela?")) {
                        DashboardChart.prototype.initDownload(object.text, html);
                    }
                } else {
                    alert('Não há dados para serem baixados');
                }
            });

        });

    } else {
        $btn.unbind('click').html('Sem informação');
    }

};