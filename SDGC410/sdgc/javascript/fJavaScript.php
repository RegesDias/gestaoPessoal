<script type="text/javascript">
    document.cookie = "SameSite=None";

    function limparHtmlDivPorId(id) {
        var elementoDiv = document.getElementById(id);
        elementoDiv.innerHTML = "";
    }

//console.log("Chamou o Javascript");
    function apagarSelect(id) {
        let select = document.getElementById(id);
        select.innerHTML = "";
    }

    function pegaElementoPorId(idElemento) {
        if (document.getElementById(idElemento)) {
            return document.getElementById(idElemento);
        }
        return null;
    }

    function existeElementoPorId(idElemento) {
        //console.log("TESTE");
        if (document.getElementById(idElemento)) {
            return true;
        }
        return false;
    }

    function preencheSelect(objSelect, vetNome, vetValor, offset = 0) {
        for (i = 0; i < vetNome.length; i++) {
            objSelect.options[i + offset] = new Option(vetNome[i]);
            objSelect.options[i + offset].value = vetValor[i];
        }
    }

    function limpaSelect(objSelect) {
        //console.log("LIPA SELECT");
        //console.log(objSelect);
        while (objSelect.options.length > 0) {
            objSelect.options[0] = null;
        }
    }

    function selecionaOptionPorValor(obj, valor) {
        for (var chave in obj.options) {
            if (obj.options[chave].value === valor) {
                obj.options[chave].selected = true;
            }
        }
    }

    function alterarPadraoDataLancamento(valor) {
        //Captura os botões para mudar a cor ao ser clicado
        var btnSim = document.getElementById('btnSim');
        var btnNao = document.getElementById('btnNao');
        //Botao sim foi clicado
        if (valor === 1) {
            //Altera o date picker para intervalo
            $('input[name="datetimes"]').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                maxSpan: "1",
                singleDatePicker: false,
                startDate: "<?= $periodoMes[0] ?> 8:00",
                endDate: "<?= $periodoMes[0] ?> 8:00",
                minDate: "<?= $periodoMes[0] ?>",
                maxDate: "<?= $periodoMes[1] ?> 23:59",
                locale: {
                    format: 'DD/MM/YYYY HH:mm'
                }
            });
            //Altera as cores dos botões
            btnSim.classList.remove('btn-secondary');
            btnSim.classList.add('btn-primary');
            btnNao.classList.remove('btn-primary');
            btnNao.classList.add('btn-secondary');
        }
        //Botao Nao foi clicado
        if (valor === 0) {
            //Altera o date picker para simples
            $('input[name="datetimes"]').daterangepicker({
                timePicker: true,
                timePicker24Hour: true,
                maxSpan: "1",
                singleDatePicker: true,
                startDate: "<?= $periodoMes[0] ?> 8:00",
                endDate: "<?= $periodoMes[0] ?> 8:00",
                minDate: "<?= $periodoMes[0] ?>",
                maxDate: "<?= $periodoMes[1] ?> 23:59",
                locale: {
                    format: 'DD/MM/YYYY HH:mm'
                }
            });
            //Altera as cores dos botões
            btnNao.classList.remove('btn-secondary');
            btnNao.classList.add('btn-primary');
            btnSim.classList.remove('btn-primary');
            btnSim.classList.add('btn-secondary');
        }
    }

    function fecharModal() {
        while (document.getElementsByClassName('modal-backdrop fade in')[0]) {
            document.getElementsByClassName('modal-backdrop fade in')[0].remove();
        }
        // document.getElementsByClassName('modal-open')[0].str.replace("modal-open", "");
        fecharModalClassRemove();
    }


    $(document).ready(function () {
        $('#imgSmile').width();

        //$('#imgSmile').mouseover(function()
        $('#imgSmile').click(function ()
        {
            $(this).css("cursor", "pointer");
            $(this).animate({width: "500px"}, 'slow');
        });

        $('#imgSmile').mouseout(function ()
        {
            $(this).animate({width: "100px"}, 'slow');
        });

        if (existeElementoPorId('descer')) {
            setTimeout(function () {
                window.scrollTo(0, 10000);
            }, 10);
        }

    });


</script>
<script>
    function fecharModalClassRemove() {
        $("#bobyPrincipal").removeClass("modal-open");
    }
    function fecharUserMenu() {
        $("#idUserMenu").removeClass("control-sidebar-open");
    }
</script>
