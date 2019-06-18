/**
 * Created by Rafael Oliveira on 03/04/2017.
 */

var BootstrapModal = function(opt){

    var globalFunction = [];


    this.appendCallBack = function(dataFunction){
        globalFunction.push(dataFunction);
    };

    this.executeCallBack = function(response){
        if(globalFunction.length){
            var currentLengthArray = globalFunction.length-1;
            globalFunction[currentLengthArray](response);
            globalFunction.splice(currentLengthArray,1);
            this.getCurrentModal().modal('hide');

        }

    };

    this.removeCallBack = function () {
        var currentLengthArray = globalFunction.length - 1;
        globalFunction.splice(currentLengthArray, 1);
    };


    this.getCurrentModal = function(){
        return $($('.modal').get($('.modal').length-1));

    }

};

BootstrapModal.prototype = function(){
    var Class;

    var init = function(){
        Class = this;
    };


    var buildFormModal = function (content, title, callback, size) {
        size = size || "";

        var html = '';
        html += '<div class="modal fade " data-backdrop="static" data-keyboard="false" >';
        html += '<div class="modal-dialog  ' + size + '">';
        html += '<div class="modal-content">';
        html += '<div class="modal-header bg-teal-active">';
        html += '';
        html += '<h4 class="modal-title">'+title+'</h4>';
        html += '</div>';
        html += '<div class="modal-body">';
        html += content;
        html += '</div>';
        html += '<div class="modal-footer">';
        html += '<button type="button" class="btn btn-primary" id="form-submit" data-loading-text="Salvando...">Salvar</button>';
        //html += '<button type="button" class="btn btn-default" data-dismiss="modal">Salvar</button>';
        html += '<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>';

        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';


        var currentModal = showModal(html,callback);

    };


    var buildModalPrint = function (content, title, size) {

        size = size || "";

        var html = '';
        html += '<div class="modal fade " data-backdrop="static" data-keyboard="false" >';
        html += '<div class="modal-dialog  ' + size + '">';
        html += '<div class="modal-content">';
        html += '<div class="modal-header bg-teal-active">';
        html += '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        html += '<h4 class="modal-title">' + title + '</h4>';
        html += '</div>';
        html += '<div class="modal-body" id="modal-printable">';
        html += content;
        html += '</div>';
        html += '<div class="modal-footer">';
        html += '<button type="button" class="btn btn-primary" id="print">Imprimir</button>';
        //html += '<button type="button" class="btn btn-default" data-dismiss="modal">Salvar</button>';
        html += '<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>';

        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        var callback = function (modal) {
            $(modal).find('#print').on('click', function (event) {

                var title = $(this).closest('.modal').find('.modal-title').html();
                var titleHead = '<table class="table"><tr><td align="center">' + title + '</td><r></table>';
                var content = $(this).closest('.modal').find('#modal-printable').html();
                content = removeElements(content, '.hiddenIbooking');
                var form = $("<form id='form-imprimir' action='/app/novoPMS/imprimirhtml' method='POST' target='_blank'>" +
                    "<input type='hidden' name='html' value='" + titleHead + content + "'>" +
                    '<input type="submit" value="enviar" />' +
                    '</form>');

                $(this).closest('.modal').find('#modal-printable').after(form);
                form.submit();
                $(this).closest('.modal').find('#form-imprimir').remove();

            });
        };

        var currentModal = showModal(html, callback);
    };


    var buildModalReversao = function (content, title, size) {

        size = size || "";

        var html = '';
        html += '<div class="modal fade " data-backdrop="static" data-keyboard="false" >';
        html += '<div class="modal-dialog  ' + size + '">';
        html += '<div class="modal-content">';
        html += '<div class="modal-header bg-red ">';
        html += '';
        html += '<h4 class="modal-title">' + title + '</h4>';
        html += '</div>';
        html += '<div class="modal-body" id="modal-printable">';
        html += content;
        html += '</div>';
        html += '<div class="modal-footer">';
        html += '<button type="button" class="btn btn-danger" id="reversao"> </button>';
        //html += '<button type="button" class="btn btn-default" data-dismiss="modal">Salvar</button>';
        html += '<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>';

        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        var callback = function (modal) {
            $(modal).find('#reversao').on('click', function (event) {
                $(modal).find('form').submit();
            });
        };

        var currentModal = showModal(html, callback);
    };


    var modalPrint = function (url, size) {
        $.ajax({
            url: url,
            dataType: 'JSON',
            type: 'GET',
            beforeSend: function () {
                loadIbooking.show($('#mainContainer'));
                // $('#mainContainer').addClass('whirl traditional');
            },
            complete: function () {
                loadIbooking.remove($('#mainContainer'));
                // $('#mainContainer').removeClass('whirl traditional');

            },
            success: function (data) {
                if (data.success == 1) {
                    buildModalPrint(data.html, data.title, size);
                } else {
                    controlPage.buildHtmlPage(data.html);
                }
            },
            error: function (x) {

                alert(x.responseText);
            }

        });
    };


    var modalReversao = function (url, size) {
        $.ajax({
            url: url,
            dataType: 'JSON',
            type: 'GET',
            beforeSend: function () {
                loadIbooking.show($('#mainContainer'));
            },
            complete: function () {
                loadIbooking.remove($('#mainContainer'));

            },
            success: function (data) {
                if (data.success == 1) {
                    buildModalReversao(data.html, data.title, size);
                } else {
                    controlPage.buildHtmlPage(data.html);
                }
            },
            error: function (x) {

                alert(x.responseText);
            }

        });
    };


    var modalForm = function (url, callback, size) {
        $.ajax({
            url: url,
            dataType: 'JSON',
            type: 'GET',
            beforeSend: function () {
                loadIbooking.show($('#mainContainer'));
            },
            complete: function () {
                loadIbooking.remove($('#mainContainer'));

            },
            success : function(data){
                if(data.success == 1){
                    buildFormModal(data.html, data.title, callback, size);
                } else {
                    controlPage.buildHtmlPage(data.html);
                }
            },
            error : function(x){

                alert(x.responseText);
            }

        });
    };



    var modalFormMini = function(url){
        $.ajax({
            url : url,
            dataType:'JSON',
            type:'GET',
            beforeSend: function () {
                loadIbooking.show($('#mainContainer'));
                // $('#mainContainer').addClass('whirl traditional');
            },
            complete: function () {
                loadIbooking.remove($('#mainContainer'));
                // $('#mainContainer').removeClass('whirl traditional');

            },
            success : function(data){
                if(data.success == 1){
                    $('body').append('<div id="targetHide" style="display: none">'+data.html+'</div>');
                    $('#targetHide').remove();
                } else {
                    controlPage.buildHtmlPage(data.html);
                }
            },
            error : function(x){

                alert(x.responseText);
            }

        });

    };




    /**
     *
     * @param header - Nome que será exibido no topo
     * @param content - Html do body
     * @param tamanho - Classe do bootstrap para definir o tamanho do modal -> Large / Small / Normal P
     */
    var buildVisualizarModal = function(header,content,tamanho) {

        var html = '';
        html += '<div class="modal fade ">';
        html += '<div class="modal-dialog '+tamanho+' ">';
        html += '<div class="modal-content">';
        html += '<div class="modal-header bg-teal-active">';
        html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        html += '<h4 class="modal-title">' + header + '</h4>';
        html += '</div>';
        html += '<div class="modal-body">';
        html += content;
        html += '</div>';
        html += '<div class="modal-footer">';
        html += '<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';


        showModal(html);

    };


    /**
     * Função responsável em exibir o modal a partir do HTML
     * @param html HTML
     * @param callback
     */
    var showModal = function(html,callback){
        $('body').append(html);
        var modalAtual = Class.getCurrentModal();
        if(typeof callback == 'function'){
            modalAtual.on('shown.bs.modal',function(){
                callback(this);
            });
            if(modalAtual.find('#form-submit').length){
                modalAtual.find('#form-submit').on('click',function(){
                    modalAtual.find('form').submit();
                });
            }

        } else {
            bootstrapModal.appendCallBack(function () {
            });
        }

        modalAtual.modal('show');
        modalAtual.on('hidden.bs.modal', function () {

            bootstrapModal.removeCallBack();
            $(this).remove();
            if ($('.modal:visible').length) {
                $('body').addClass('modal-open');
            }
        });


        return modalAtual;
    };


    /**
     Função responsável em construir o modal de confirmação
     @param closureFunction - function(data) retorna dentro do parametro o modal em questão;
     @param content - string(html) exibe a mensagem;
     */
    var buildConfirmModal = function(closureFunction,content){
        var html = '';
        html += '<div id="modalConfirmacao" class="modal fade ">';
        html += '<div class="modal-dialog">';
        html += '<div class="modal-content">';
        html += '<div class="modal-header bg-blue">';
        html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        html += '<h4 class="modal-title"><i class="fa fa-warning"></i> Confirmação</h4>';
        html += '</div>';
        html += '<div class="modal-body">';
        html += content;
        html += '</div>';
        html += '<div class="modal-footer">';
        html += '<a  id="confirmBtn" class="btn btn-primary" >Confirmar</a>';
        html += '<button type="button" id="closeBtn" class="btn btn-default" data-dismiss="modal">Fechar</button>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

        showModal(html);

        var currentModal = $(this.getCurrentModal());
        currentModal.find('#confirmBtn').on('click',function(){
            closureFunction(currentModal);
        });
        return currentModal;

    };

    var buildFormModalMini = function (content, callback) {

        var html = '';
        html += '<div class="modal fade ">';
        html += '<div class="modal-dialog  ">';
        html += '<div class="modal-content">';
        html += '<div class="modal-header bg-teal-active">';
        html += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
        html += '<h4 class="modal-title">Implementar</h4>';
        html += '</div>';
        html += '<div class="modal-body">';
        html += content;
        html += '</div>';
        html += '<div class="modal-footer">';
        html += '<button type="button" class="btn btn-primary" id="form-submit" data-loading-text="Salvando...">Salvar</button>';
        html += '<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>';

        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';


        var currentModal = showModal(html, callback);

    };


    var removeElements = function (text, selector) {
        var wrapped = $("<div>" + text + "</div>");
        wrapped.find(selector).remove();
        return wrapped.html();
    };


    var getLengthModal = function(){
        return Class.getCurrentModal();
    };

    return {
        init :init,
        getLengthModal:getLengthModal,
        modalForm:modalForm,
        modalFormMini:modalFormMini,
        buildConfirmModal:buildConfirmModal,
        buildFormModal:buildFormModal,
        buildFormModalMini: buildFormModalMini,
        modalPrint: modalPrint,
        modalReversao: modalReversao,
        buildVisualizarModal: buildVisualizarModal

    };
}();
var bootstrapModal = new BootstrapModal({length:0});
bootstrapModal.init();



