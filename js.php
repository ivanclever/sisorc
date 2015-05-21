<!-- Le javascript
================================================== -->
<!-- Important plugins put in all pages -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap/bootstrap.js?<?=rand()?>"></script>  
<script type="text/javascript" src="js/jquery_cookie.js?<?=rand()?>"></script>
<script type="text/javascript" src="js/jquery.mousewheel.js?<?=rand()?>"></script>

<!-- Form plugins -->
<script type="text/javascript" src="plugins/forms/watermark/jquery.watermark.min.js?<?=rand()?>"></script>
<script type="text/javascript" src="plugins/forms/uniform/jquery.uniform.min.js?<?=rand()?>"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js?<?=rand()?>"></script>

<!-- Fix plugins -->
<script type="text/javascript" src="plugins/fix/ios-fix/ios-orientationchange-fix.js?<?=rand()?>"></script>

<!-- Table plugins -->
<script type="text/javascript" src="plugins/tables/dataTables/jquery.dataTables.js?<?=rand()?>"></script>
<script type="text/javascript" src="plugins/tables/responsive-tables/responsive-tables.js?<?=rand()?>"></script><!-- Make tables responsive -->

<script type="text/javascript" src="plugins/misc/prettify/prettify.js?<?=rand()?>"></script><!-- Code view plugin -->
<script type="text/javascript" src="plugins/misc/totop/jquery.ui.totop.min.js?<?=rand()?>"></script>

<!-- Init plugins -->
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.1.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.ui.combogrid-1.6.3.js?<?=rand()?>"></script>
<script type="text/javascript" src="js/main.js?<?=rand()?>"></script><!-- Core js functions -->
<script type="text/javascript" src="js/forms.js?<?=rand()?>"></script><!-- Init plugins only for page -->
<script type="text/javascript" src="js/cep.js?<?=rand()?>"></script><!-- Init plugins only for page -->
<script type="text/javascript" src="js/datatable.js?<?=rand()?>"></script><!-- Init plugins only for page -->
<script type="text/javascript" src="js/mask.js?<?=rand()?>"></script><!-- Init plugins only for page -->
<script type="text/javascript" src="js/maskpreco.js?<?=rand()?>"></script><!-- Init plugins only for page -->
<script type="text/javascript" src="js/form-validation.js?<?=rand()?>"></script><!-- Init plugins only for page -->
<script type="text/javascript" src="js/maxlength.js?<?=rand()?>"></script><!-- limit -->
<script type="text/javascript" src="js/widgets.js?<?=rand()?>"></script><!-- Init plugins only for page -->
<script type="text/javascript" src="js/jquery-gmaps-latlon-picker.js?<?=rand()?>"></script><!-- Init plugins only for page -->

<script type="text/javascript">
$(function(){
	$('.del').click(function(){ if (confirm('Deseja remover este Registro ?')) return true; else return false; });

	$('#openChamada').click(function(){
		$('#dialogChamada').dialog('open');
		return false;
	});

	// JQuery Dialog			
	$('#dialogChamada').dialog({
		autoOpen: false,
		dialogClass: 'dialog',
		buttons: {
			"Fechar": function() {
				$(this).dialog("close"); 
			}
		}
	});

	$('#openDetalhes').click(function(){
		$('#dialogDetalhes').dialog('open');
		return false;
	});

	// JQuery Dialog			
	$('#dialogDetalhes').dialog({
		autoOpen: false,
		dialogClass: 'dialog',
		buttons: {
			"Fechar": function() { 
				$(this).dialog("close"); 
			}
		}
	});

	// JQuery UI Modal Dialog			
	$('#modal').dialog({
		autoOpen: false,
		modal: true,
		dialogClass: 'dialog',
		buttons: {
			"Fechar": function() { 
				$(this).dialog("close"); 
			}
		}
	});

	$("div.dialog button").addClass("btn");

	//distribuidores
	$('#estados').change(function(){
        if( $(this).val() ) {
            $('#cidades').hide();
            $('.carregando').show();
            $.getJSON('ajax.php?search=',{cod_estados: $(this).val(), ajax: 'true'}, function(j){
                var options = '<option value=""></option>'; 
                for (var i = 0; i < j.length; i++) {
                    options += '<option value="' + j[i].cod_cidades + '">' + j[i].nome + '</option>';
                }   
                $('#cidades').html(options).show();
                $('.carregando').hide();
            });
        } else {
            $('#cidades').html('<option value="">-- Escolha um estado --</option>');
        }
    });

	$('.cep').mask("99999-999");
	$('.data').mask("99/99/9999");

	$('input.cpf').mask("999.999.999-99");
	$('input.cnpj').mask("99.999.999/9999-99");

	//$('.moeda').priceFormat({ prefix: '', centsSeparator: ',', thousandsSeparator: '' });
	//$('.preco').priceFormat({ prefix: '', centsSeparator: ',', thousandsSeparator: '.' });

	$('.telefone, .fax, .celular').focusout(function(){
	    var phone, element;
	    element = $(this);
	    element.unmask();
	    phone = element.val().replace(/\D/g, '');
	    if(phone.length > 10) {
	        element.mask("(99) 99999-999?9");
	    } else {
	        element.mask("(99) 9999-9999?9");
	    }
	}).trigger('focusout');

	setformfieldsize(jQuery('#descricao'), 400, 'charsremain')
});
</script>