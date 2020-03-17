<script type="text/javascript">
    function apagarSelect(id){
        let select = document.getElementById(id);
        select.innerHTML = "";
    }
    
    
    function exibeCompetencia(){
       //Pega Os Elementos da Tela
       var divCompetencia = document.getElementById('idDivCompetencia');
       var divNR = document.getElementById('idDivNR');
       var btnCompetencia = document.getElementById('btnCompetencia');
       var btnNR = document.getElementById('btnNr');
       var flagOrganizarPor = document.getElementById('idFlagOrgPor');
       flagOrganizarPor.setAttribute('value', 'competencia');
       //Exibe a Div Competencia
       if(divCompetencia.classList.contains('collapse')){
           divCompetencia.classList.remove('collapse');
       }
       //Esconde a Nr
       if(!divNR.classList.contains('collapse')){
           divNR.classList.add('collapse');
       }
       //Muda a cor do botão competencia
       if(!btnCompetencia.classList.contains('btn-primary')){
           btnCompetencia.classList.add('btn-primary');
       }
       //Coloca o botão Nr cinza
       if(btnNR.classList.contains('btn-primary')){
           btnNR.classList.remove('btn-primary');
       }
    }
    
    function exibeNR(){
       //Pega Os Elementos da Tela
       var divCompetencia = document.getElementById('idDivCompetencia');
       var divNR = document.getElementById('idDivNR');
       var btnCompetencia = document.getElementById('btnCompetencia');
       var btnNR = document.getElementById('btnNr');
       var flagOrganizarPor = document.getElementById('idFlagOrgPor');
       flagOrganizarPor.setAttribute('value', 'nr');
       //Exibe a div Nr
       if(divNR.classList.contains('collapse')){
           divNR.classList.remove('collapse') 
       }
       //Esconde a div Nr
       if(!divCompetencia.classList.contains('collapse')){
           divCompetencia.classList.add('collapse')
       }
       //Faz o botao competencia cinza
       if(btnCompetencia.classList.contains('btn-primary')){
           btnCompetencia.classList.remove('btn-primary');
       }
       //Coloca o botão Nr azul
       if(!btnNR.classList.contains('btn-primary')){
           btnNR.classList.add('btn-primary');
       }
    }
    
    function alterarPadraoDataLancamento(valor){
        //Captura os botões para mudar a cor ao ser clicado
       var btnSim = document.getElementById('btnSim');
       var btnNao = document.getElementById('btnNao');
       //Botao sim foi clicado
       if(valor===1){
           //Altera o date picker para intervalo
           $('input[name="datetimes"]').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            maxSpan:"1",
            singleDatePicker:false,
            startDate: "<?=$periodoMes[0]?> 8:00",
            endDate: "<?=$periodoMes[0]?> 8:00",
            minDate: "<?=$periodoMes[0]?>",
            maxDate: "<?=$periodoMes[1]?> 23:59",
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
       if(valor===0){
           //Altera o date picker para simples
           $('input[name="datetimes"]').daterangepicker({
            timePicker: true,
            timePicker24Hour: true,
            maxSpan:"1",
            singleDatePicker:true,
            startDate: "<?=$periodoMes[0]?> 8:00",
            endDate: "<?=$periodoMes[0]?> 8:00",
            minDate: "<?=$periodoMes[0]?>",
            maxDate: "<?=$periodoMes[1]?> 23:59",
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
    $(document).ready(function(){
       $('#imgSmile').width();
       //$('#imgSmile').mouseover(function()
       $('#imgSmile').click(function()
       {
          $(this).css("cursor","pointer");
          $(this).animate({width: "500px"}, 'slow');
       });
    
    $('#imgSmile').mouseout(function()
      {   
          $(this).animate({width: "100px"}, 'slow');
       });
   });
    
</script>
