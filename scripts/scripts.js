$(document).ready(function(){
	
	function ShowMsg(vTexto){
		$.fancybox.hideLoading();
		$('#modal_message').html(vTexto),
		$('#modal_message').dialog({
			width: 'auto',
			height: 'auto',
			modal: true,
			buttons: {
				Ok: function() {
					$(this).dialog('close');
				},
				'Imprimir': function(){
					PrintSorter();
				},
				'Exportar XLS': function(){
					ExportarXLS();
				}
			}
		});				
	}
	
	function EnterLogin(){
		
		$('#cefal-rs_usuario').on('keyup', function(e) {
			if (e.which == 13 || e.keyCode == 13) {
				$("#buttons_auth_login").click();
			}
		});
		
		$('#cefal-rs_senha').on('keyup', function(e) {
			if (e.which == 13 || e.keyCode == 13) {
				$("#buttons_auth_login").click();
			}
		});
	}
	
	function DatePickerToBr(classe){
		/*	Tradução dos calendários	*/
		$( '.'+classe+'' ).datepicker({ dateFormat: 'dd/mm/yy' });
		var dayNames = $( '.date' ).datepicker( 'option', 'dayNames' );
		$(  '.'+classe+'' ).datepicker( 'option', 'dayNames', [ 'Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado' ] );
		var dayNamesMin = $( '.date' ).datepicker( 'option', 'dayNamesMin' );
		$(  '.'+classe+'' ).datepicker( 'option', 'dayNamesMin', [ 'Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab' ] );	
		var monthNames = $( '.date' ).datepicker( 'option', 'monthNames' );
		$(  '.'+classe+'' ).datepicker( 'option', 'monthNames', [ 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro' ] );
		var nextText = $( '.date' ).datepicker( 'option', 'nextText' );
		$(  '.'+classe+'' ).datepicker( 'option', 'nextText', 'Avançar' );
		var prevText = $( '.date' ).datepicker( 'option', 'prevText' );
		$(  '.'+classe+'' ).datepicker( 'option', 'prevText', 'Voltar' );
		
		$('.'+classe+'').mask('99/99/9999');
		
	}

	function masks(){
	
		/*	Fim da tradução	*/
		$('.time').timepicker();

		$('.datetime').datetimepicker({ dateFormat: 'dd/mm/yy', timeFormat: 'HH:mm' });
	
		/*	Mascara para as datas e horas	*/
		$('.datetime').mask('99/99/9999 99:99');
		$('.date').mask('99/99/9999');
		$('.time').mask('99:99');

		/*	Mascara para endereço	*/
		$('.cep').mask('99999-999');
	
		/*	Mascara para dados pessoais	*/
		$('.cpf').mask('999.999.999-99');
		$('.rg').mask('9999999999');	
		$('.telefone').mask('+559999999999');
		
		/*	Até agora não rolou :(	*/
		//$('.email').mask('@.');
	}
	
	masks();
	
	$(function() {
		$( "#tabs" ).tabs();
	});
	
	function ExportarXLS(){
		var table_xls;
		var table_xls = $('.tablesorter').parent().html();
		
		table_xls = encodeURIComponent(table_xls);
		window.location.href='exportar/xls.php?table_xls='+table_xls;
	}	

	function PrintSorter(){
		$('.tablesorter').printThis({
			debug: false,					//show the iframe for debugging
			importCSS: true,				//import page CSS
			printContainer: true,			//grab outer container as well as the contents of the selector
			loadCSS: 'css/print_sorter.css',	//path to additional css file
			pageTitle: 'CEFAL-RS',	//add title to print page
			removeInline: true				//remove all inline styles from print elements
		});
	}

	function ListarAdministradores(logado){
		$("#listar_administradores").click(function(){
			
			$.ajax({
				type: 'POST',
				url: 'config/listar_administradores.php',
				dataType: 'html',
				
				beforeSend: function() {
					$.fancybox.showLoading();
				},
				
				success: function(response){
					$.fancybox.hideLoading();
					$('#modal_message').html(response),
					$('#modal_message').dialog({
						width: '1000px',
						height: 'auto',
						modal: true,
						buttons: {
							Ok: function() {
								$(this).dialog('close');
							}
						}
					});
					$('.tablesorter').tablesorter();
					$(".editar_administrador").on('click', function(){
						var id_objeto = jQuery(this).attr("id");
						$.ajax({
							type: 'POST',
							url: 'config/editar_administradores.php',
							data: {
								session:logado.session,
								id : 	id_objeto
							},
				
							beforeSend: function() {
								$.fancybox.showLoading();
							},
							
							dataType: 'html',
							
							success: function(retorno_html){
								$.fancybox.hideLoading();
								$('#modal_message').html(retorno_html),
								$('#modal_message').dialog({
									width: '485px',
									height: 'auto',
									modal: true,
									buttons: {
										'Atualizar': function(){
											 AtualizarAdministrador(logado);
										},
										'Cancelar': function(){
											$("#listar_administradores").click(function(){
												BuscarComEdicao();
											});
										}
									}
								});
							}
						});	
					});
				}
			});			
		});
	}

	function AdicionarAdministrador(logado){
		$("#adicionar_administrador").click(function(){
			$.ajax({
				type: 'POST',
				url: 'config/adicionar_administrador.php',
				data: {
					session:logado.session,
					id : 	logado.id
				},

				beforeSend: function(){
					$.fancybox.showLoading();
				},
				
				dataType: 'html',
				
				success: function(retorno_html){
					$.fancybox.hideLoading();
					$('#modal_message').html(retorno_html),
					$('#modal_message').dialog({
						width: '485px',
						height: 'auto',
						modal: true,
						buttons: {
							'Inserir': function(){
								 InserirAdministrador(logado); 
							},
							'Cancelar': function(){
								$(this).dialog('close');
							}
						}
					});
				}
			});	
		});	
	}
	
	function InserirAdministrador(response){
								
		$.ajax({			
			type: 'POST',
			url: 'config/inserir_administrador.php',				
			dataType: 'html',
			data: {
				// 	Receber administrador.
				adicionar_administrador_nome	:	$('input:text[name=adicionar_administrador_nome]').val(),
				adicionar_administrador_email	:	$('input:text[name=adicionar_administrador_email]').val(),
				adicionar_administrador_usuario	:	$('input:text[name=adicionar_administrador_usuario]').val(),
				adicionar_administrador_senha	:	$('input:password[name=adicionar_administrador_senha]').val(),
				adicionar_grupo_administrador	:	1,
				adicionar_telefone_administrador	:	$('input:text[name=adicionar_telefone_administrador]').val(),
				
				// 	Receber editor administrador.
				id								:	response.id,
				session							:	response.session
				
			},
			
			beforeSend: function() {
				$.fancybox.showLoading();
			},
			
			success: function(response_adicionar){
				$.fancybox.hideLoading();
				$('#modal_message').html(response_adicionar),
				$('#modal_message').dialog({
					modal: true,
					buttons: {
						Ok: function() {
							$(this).dialog('close');
						}
					}
				});
			},

			error: function (xhr, ajaxOptions, thrownError){
				$.fancybox.hideLoading();
				$('#modal_message').html(thrownError),
				$('#modal_message').dialog({
					modal: true,
					buttons: {
						Ok: function() {
							$(this).dialog('close');
						}
					}
				});					
				
				//alert('Login e senha são obrigatórios');
				//$.fancybox(''+thrownError+'');		
				//alert(xhr.status);
				//alert(thrownError);
			}
		});
	}
	
	function Gravar(){
	
		$('.adicionar').click(function(){
								
			$.ajax({			
				type: 'POST',
				url: 'adicionar/adicionar.php',				
				dataType: 'html',
				data: {
					// 	Receber Associado.
					adicionar_matricula							:	$('input:text[name=adicionar_matricula]').val(),
					adicionar_nome							:	$('input:text[name=adicionar_nome]').val(),			
					adicionar_cpf								:	$('input:text[name=adicionar_cpf]').val(),
					adicionar_rg								:	$('input:text[name=adicionar_rg]').val(),					
					adicionar_data_de_nascimento 				:	$('input:text[name=adicionar_data_de_nascimento]').val(),
					
					// 	Receber Telefones
					adicionar_telefones							:	$('input:text[name=adicionar_telefones]').serialize(),
					
					// 	Receber E-mails
					adicionar_emails							:	$('input:text[name=adicionar_emails]').serialize(),
					
					// 	Receber Endereço
					adicionar_logradouro						:	$('input:text[name=adicionar_logradouro]').val(),
					adicionar_cep								:	$('input:text[name=adicionar_cep]').val(),
					adicionar_municipio							:	$('select[name=adicionar_municipio]').val(),
					adicionar_bairro							:	$('input:text[name=adicionar_bairro]').val(),
					
					// 	Receber Dependentes
					adicionar_nomes_dependentes				:	$('input:text[name=adicionar_nomes_dependentes]').serialize(),
					adicionar_datas_de_nascimentos_dependentes	:	$('input:text[name=adicionar_datas_de_nascimentos_dependentes]').serialize(),
				
					// 	Receber Banco
					adicionar_banco							:	$('input:text[name=adicionar_banco]').val(),
					adicionar_agencia							:	$('input:text[name=adicionar_agencia]').val(),
					adicionar_conta							:	$('input:text[name=adicionar_conta]').val(),

					//	Receber Contabel
					adicionar_salario							:	$('input:text[name=adicionar_salario]').val(),
					adicionar_limite_credito						:	$('input:text[name=adicionar_limite_credito]').val(),
					adicionar_limite_usado						:	$('input:text[name=adicionar_limite_usado]').val(),

					//	Receber Dados AL
					adicionar_gabinete							:	$('input:text[name=adicionar_gabinete]').val(),
					adicionar_categoria							:	$('#adicionar_categoria').val(),
					adicionar_setor							:	$('#adicionar_setor').val(),
					adicionar_coordenadoria						:	$('#adicionar_coordenadoria').val()
				},
				
				beforeSend: function() {
					$.fancybox.showLoading();
				},
				
				success: function(response_adicionar){
					$.fancybox.hideLoading();
					$('#modal_message').html(response_adicionar),
					$('#modal_message').dialog({
						modal: true,
						buttons: {
							Ok: function() {
								$(this).dialog('close');
							}
						}
					});
				},

				error: function (xhr, ajaxOptions, thrownError){
					$.fancybox.hideLoading();
					$('#modal_message').html(thrownError),
					$('#modal_message').dialog({
						modal: true,
						buttons: {
							Ok: function() {
								$(this).dialog('close');
							}
						}
					});					
					
					//alert('Login e senha são obrigatórios');
					//$.fancybox(''+thrownError+'');		
					//alert(xhr.status);
					//alert(thrownError);
				}
			});
		});
	}
	
	function AtualizarAdministrador(response){
		
		$.ajax({			
			type: 'POST',
			url: 'config/atualizar_administrador.php',
			dataType: 'html',
			data: {

				atualizar_administrador_id			:	$('input:text[name=atualizar_administrador_id]').val(),
				atualizar_administrador_nome		:	$('input:text[name=atualizar_administrador_nome]').val(),
				atualizar_administrador_email		:	$('input:text[name=atualizar_administrador_email]').val(),
				atualizar_administrador_usuario		:	$('input:text[name=atualizar_administrador_usuario]').val(),
				atualizar_administrador_senha		:	$('input:password[name=atualizar_administrador_senha]').val(),
				atualizar_grupo_id					:	$('.atualizar_grupo_administrador').attr('id'),
				
				atualizar_telefone_id				:	$('input:text[name=atualizar_telefone_id]').val(),
				atualizar_telefone					:	$('input:text[name=atualizar_telefone]').val(),
				
				atualizar_administrador_status		:	$('select[name=atualizar_administrador_status]').val(),
				
				session								:	response.session,
				id									:	response.id
			},
			
			beforeSend: function() {
				$.fancybox.showLoading();
			},
			
			success: function(response_atualizar){
				$.fancybox.hideLoading();
				$('#modal_message').html(response_atualizar),
				$('#modal_message').dialog({
					width: 'auto',
					height: 'auto',
					modal: true,
					buttons: {
						Ok: function() {
							$("#listar_administradores").click();
						}
					}
				});
			},

			error: function (xhr, ajaxOptions, thrownError){
				$.fancybox.hideLoading();
				$('#modal_message').html(thrownError),
				$('#modal_message').dialog({
					width: 'auto',
					height: 'auto',
					modal: true,
					buttons: {
						Ok: function() {
							$("#listar_administradores").click();
						}
					}
				});	
			}
		});
	}
	
	function Buscar(){
	
		$('#buscar').click(function(){
			var vPossuiSelecionado = false;
			$('input[type=checkbox]').each(function () {
			   if(this.checked){
					vPossuiSelecionado = true;
				}
			});
			if(vPossuiSelecionado){
				$.ajax({			
					type: 'POST',
					url: 'busca/buscar.php',			
					dataType: 'html',
					data: {
						// 	Receber Textos.
						buscar_nome								:	$('input:text[name=nome]').val(),
						buscar_matricula							:	$('input:text[name=matricula]').val(),
						buscar_cep								:	$('input:text[name=cep]').val(),
						buscar_gabinete							:	$('input:text[name=gabinete]').val(),
						
						// 	Receber Selects
						buscar_coordenadoria						:	$('select[name=coordenadoria]').val(),					
						buscar_categoria							:	$('select[name=categoria]').val(),
						buscar_setor								:	$('select[name=setor]').val(),
						buscar_municipio								:	$('select[name=municipio]').val(),
						
						// 	Receber Checkbox
						retorno_busca								:	$('input[type=checkbox]:checked').serialize()
					},
					
					beforeSend: function() {
						$.fancybox.showLoading();
					},
					
					success: function(response_buscar){
						$('#modal_message').html(response_buscar),
						$('#modal_message').dialog({
							width: 'auto',
							height: 'auto',
							modal: true,
							buttons: {
								'Imprimir': function(){
									PrintSorter();
								},
								'Exportar XLS': function(){
									ExportarXLS();
								},
								Ok: function() {
									$(this).dialog('close');
								}
							}
						});
						
						$('.tablesorter').tablesorter();
						$.fancybox.hideLoading();
						MostraTelefones();
						MostraEmails();
						MostraDependentes();
					},

					error: function (xhr, ajaxOptions, thrownError){
						ShowMsg(thrownError)						;
						
						//alert('Login e senha são obrigatórios');
						//$.fancybox(''+thrownError+'');		
						//alert(xhr.status);
						//alert(thrownError);
					}
				});
			}
			else{
				ShowMsg("Selecione pelo menos 1 dos itens.");
			}
		});
	}
	
	function BuscarComEdicao(){
	
		$('#buscar').click(function(){
			var vPossuiSelecionado = false;
			$('input[type=checkbox]').each(function () {
			   if(this.checked){
					vPossuiSelecionado = true;
				}
			});
			if(vPossuiSelecionado){
				$.ajax({			
					type: 'POST',
					url: 'busca/buscar.php',			
					dataType: 'html',
					data: {
						// 	Receber Textos.
						buscar_nome								:	$('input:text[name=nome]').val(),
						buscar_matricula							:	$('input:text[name=matricula]').val(),
						buscar_cep								:	$('input:text[name=cep]').val(),
						buscar_gabinete							:	$('input:text[name=gabinete]').val(),
						
						// 	Receber Selects
						buscar_coordenadoria						:	$('select[name=coordenadoria]').val(),					
						buscar_categoria							:	$('select[name=categoria]').val(),
						buscar_setor								:	$('select[name=setor]').val(),
						
						// 	Receber Checkbox
						retorno_busca								:	$('input[type=checkbox]:checked').serialize(),
						
						buscar_edicao : "1"
					},
					
					beforeSend: function() {
						$.fancybox.showLoading();
					},
					
					success: function(response_buscar){
						$('#modal_message').html(response_buscar),
						$('#modal_message').dialog({
							width: 'auto',
							height: 'auto',
							modal: true,
							buttons: {
								'Imprimir': function(){
									PrintSorter();
								},
								'Exportar XLS': function(){
									ExportarXLS();
								},
								Ok: function() {
									$(this).dialog('close');
								}
							}
						});
						
						$('.tablesorter').tablesorter();
						$.fancybox.hideLoading();
						MostraTelefones();
						MostraEmails();
						MostraDependentes();
						EdicaoAssociado();
					},
					error: function (xhr, ajaxOptions, thrownError){
						ShowMsg(thrownError);
						
						//alert('Login e senha são obrigatórios');
						//$.fancybox(''+thrownError+'');		
						//alert(xhr.status);
						//alert(thrownError);
					}
				});				
			}
			else{
				ShowMsg("Selecione pelo menos 1 dos itens.");
			}
		});
	}	
	
	function EdicaoAssociado(){
		//$(".edicao_associado").click(function(){
		$('.edicao_associado').one('click', function() {
			
			var id_associado = jQuery(this).attr("id_associado");
			
			$.ajax({
				type: 'POST',
				url: 'editando_associado/index.php',
				data: {
					session: true,
					associado: id_associado
				},
				dataType: 'json',
				
				success: function(response){
							
					$('#tabs ul').append('<li><a href="#tabs-4">Editando associado '+ id_associado +'</a></li>');
					
					$('#tabs').append(response.retorno_html);
					
					$("#tabs").tabs("refresh");
					
					$("#modal_message").dialog('close');
					
					$('a[href="#tabs-4"]').click();
					
					var smmail = response.emails;
					var smtel = response.telefones;
					var smdep = response.dependentes;
					
					$('.removethisdependente').on('click', function(){
						var id_linha = jQuery(this).attr("linha");
						$('#nodedep'+id_linha).remove();
					});
					
					$('.removethistelefone').on('click', function(){
						var id_linha = jQuery(this).attr("linha");
						$('#nodetel'+id_linha).remove();
					});

					$('.removethisemail').on('click', function(){
						var id_linha = jQuery(this).attr("linha");
						$('#nodemail'+id_linha).remove();
					});
					
					$('.addnodeemail').on('click', function(){
						smmail = smmail + 1;
						var html =	'<div class="newnodeemail" id="nodemail'+smmail+'">';
						html = html+	'	<input type="text" class="emails email" name="atualizar_emails" style="width: 200px;" placeholder="e-mail@dominio.tld"/>';
						html = html+	'	<div class="removethisemail" id="remmail'+smmail+'" linha="'+smmail+'"> -</div>';
						html = html+	'</div>';
						$('.nodeemail').append(html);
					
						$('.removethisemail').on('click', function(){
							var id_linha = jQuery(this).attr("linha");
							$('#nodemail'+id_linha).remove();
						});						
					});

					$('.addnodetelefone').on('click', function(){
						smtel = smtel + 1;
						
						var html =	'<div class="newnodetelefone" id="nodetel'+smtel+'">';
						html = html+'	<input type="text" class="telefones telefone" name="atualizar_telefones" style="width: 200px;" placeholder="+555132102002"/>';
						html = html+'	<div class="removethistelefone" id="remtel'+smtel+'" linha="'+smtel+'"> -</div>';
						html = html+'</div>';
						$('.nodetelefone').append(html);
					
						$('.removethistelefone').on('click', function(){
							var id_linha = jQuery(this).attr("linha");
							$('#nodetel'+id_linha).remove();
						});
						
						masks();
						
					}); 
					$('.addnodedependente').on('click', function(){
												
						smdep = smdep + 1;
						
						var	html =  '<div class="newnodedependente" id="nodedep'+smdep+'">';
						html = html+'	<div class="form_campos_medios">';
						html = html+'	<span>Nome</span><br/>';
						html = html+'		<input type="text" name="atualizar_nomes_dependentes" class="nomes_dependentes" style="width: 400px;" value=""/>';
						html = html+'	</div>';
						html = html+'	<div class="form_campos_curtos">';
						html = html+'		<span>Data de nascimento</span>';
						html = html+'		<br/>';
						html = html+'		<input type="text" name="atualizar_datas_de_nascimentos_dependentes" class="datas_de_nascimentos_dependentes" style="width: 200px;" value="" placeholder="__/__/____" />';
						html = html+'		<div class="removethisdependente" id="remdep'+smdep+'" linha="'+smdep+'"> -</div>';
						html = html+'	</div>';
						html = html+'</div>';
						$('.nodedependente').append(html);
					
						$('.removethisdependente').on('click', function(){
							var id_linha = jQuery(this).attr("linha");
							$('#nodedep'+id_linha).remove();
						});
					}); 
					
					$("#atualiza_associado").click(function(){	
						
						$.ajax({			
							type: 'POST',
							url: 'editando_associado/editar.php',			
							dataType: 'html',
							data: {
								// 	Receber Associado.
								atualizar_matricula							:	$('input:text[name=atualizar_matricula]').val(),
								atualizar_nome							:	$('input:text[name=atualizar_nome]').val(),			
								atualizar_cpf								:	$('input:text[name=atualizar_cpf]').val(),
								atualizar_rg								:	$('input:text[name=atualizar_rg]').val(),					
								atualizar_data_de_nascimento 				:	$('input:text[name=atualizar_data_de_nascimento]').val(),
								
								// 	Receber Telefones
								atualizar_telefones							:	$('input:text[name=atualizar_telefones]').serialize(),
								
								// 	Receber E-mails
								atualizar_emails							:	$('input:text[name=atualizar_emails]').serialize(),
								
								// 	Receber Endereço
								atualizar_logradouro						:	$('input:text[name=atualizar_logradouro]').val(),
								atualizar_cep								:	$('input:text[name=atualizar_cep]').val(),
								atualizar_municipio							:	$('select[name=atualizar_municipio]').val(),
								atualizar_bairro							:	$('input:text[name=atualizar_bairro]').val(),
								
								// 	Receber Dependentes
								atualizar_nomes_dependentes				:	$('input:text[name=atualizar_nomes_dependentes]').serialize(),
								atualizar_datas_de_nascimentos_dependentes	:	$('input:text[name=atualizar_datas_de_nascimentos_dependentes]').serialize(),
							
								// 	Receber Banco
								atualizar_banco							:	$('input:text[name=atualizar_banco]').val(),
								atualizar_agencia							:	$('input:text[name=atualizar_agencia]').val(),
								atualizar_conta							:	$('input:text[name=atualizar_conta]').val(),

								//	Receber Contabel
								atualizar_salario							:	$('input:text[name=atualizar_salario]').val(),
								atualizar_limite_credito						:	$('input:text[name=atualizar_limite_credito]').val(),
								atualizar_limite_usado						:	$('input:text[name=atualizar_limite_usado]').val(),

								//	Receber Dados AL
								atualizar_gabinete							:	$('input:text[name=atualizar_gabinete]').val(),
								atualizar_categoria							:	$('#atualizar_categoria').val(),
								atualizar_setor							:	$('#atualizar_setor').val(),
								atualizar_coordenadoria						:	$('#atualizar_coordenadoria').val(),
								edicao_id								:	id_associado
							},
							
							beforeSend: function() {
								$.fancybox.showLoading();
							},
							
							success: function(response_buscar2){
								$("#tabs").tabs("refresh");
								
								$('a[href="#tabs-4"]').parent().remove(); 
								$("div#tabs-5").remove();
								$('a[href="#tabs-1"]').click();
								
								$("#tabs").tabs("refresh");
								$.fancybox.hideLoading();
								$('#modal_message').html(response_buscar2),
								$('#modal_message').dialog({
									width: 'auto',
									height: 'auto',
									modal: true,
									buttons: {
										Ok: function() {
											$.ajax({			
												type: 'POST',
												url: 'busca/buscar.php',			
												dataType: 'html',
												data: {
													// 	Receber Textos.
													buscar_nome								:	$('input:text[name=nome]').val(),
													buscar_matricula							:	$('input:text[name=matricula]').val(),
													buscar_cep								:	$('input:text[name=cep]').val(),
													buscar_gabinete							:	$('input:text[name=gabinete]').val(),
													
													// 	Receber Selects
													buscar_coordenadoria						:	$('select[name=coordenadoria]').val(),					
													buscar_categoria							:	$('select[name=categoria]').val(),
													buscar_setor								:	$('select[name=setor]').val(),
													
													// 	Receber Checkbox
													retorno_busca								:	$('input[type=checkbox]:checked').serialize(),
													
													buscar_edicao : "1"
												},
												
												beforeSend: function() {
													$.fancybox.showLoading();
												},
												
												success: function(response_buscar){
													$.fancybox.hideLoading();
													$('#modal_message').html(response_buscar),
													$('#modal_message').dialog({
														width: 'auto',
														height: 'auto',
														modal: true,
														buttons: {
															'Imprimir': function(){
																PrintSorter();
															},
															'Exportar XLS': function(){
																ExportarXLS();
															},
															Ok: function() {
																$(this).dialog('close');
															}
														}
													});	
													$('.tablesorter').tablesorter();
													$.fancybox.hideLoading();
													EdicaoAssociado();
													MostraTelefones();
													MostraEmails();
													MostraDependentes();
												},

												error: function (xhr, ajaxOptions, thrownError){
													ShowMsg(thrownError)						;
													
													//alert('Login e senha são obrigatórios');
													//$.fancybox(''+thrownError+'');		
													//alert(xhr.status);
													//alert(thrownError);
												}
											});
										}
									}
								});	
							},

							error: function (xhr, ajaxOptions, thrownError){
								
								ShowMsg(thrownError);
								
								//alert('Login e senha são obrigatórios');
								//$.fancybox(''+thrownError+'');		
								//alert(xhr.status);
								//alert(thrownError);
							}
						});
						
					});
					
					$("#cancela_associado").click(function(){
						$("#tabs").tabs("refresh");
						
						$('a[href="#tabs-4"]').parent().remove(); 
						$("div#tabs-5").remove();
						$('a[href="#tabs-1"]').click();
						
						$("#tabs").tabs("refresh");
						$.fancybox.hideLoading();
						$.ajax({			
							type: 'POST',
							url: 'busca/buscar.php',			
							dataType: 'html',
							data: {
								// 	Receber Textos.
								buscar_nome								:	$('input:text[name=nome]').val(),
								buscar_matricula							:	$('input:text[name=matricula]').val(),
								buscar_cep								:	$('input:text[name=cep]').val(),
								buscar_gabinete							:	$('input:text[name=gabinete]').val(),
								
								// 	Receber Selects
								buscar_coordenadoria						:	$('select[name=coordenadoria]').val(),					
								buscar_categoria							:	$('select[name=categoria]').val(),
								buscar_setor								:	$('select[name=setor]').val(),
								
								// 	Receber Checkbox
								retorno_busca								:	$('input[type=checkbox]:checked').serialize(),
								
								buscar_edicao : "1"
							},
							
							beforeSend: function() {
								$.fancybox.showLoading();
							},
							
							success: function(response_buscar){
								$.fancybox.hideLoading();
								$('#modal_message').html(response_buscar),
								$('#modal_message').dialog({
									width: 'auto',
									height: 'auto',
									modal: true,
									buttons: {
										'Imprimir': function(){
											PrintSorter();
										},
										'Exportar XLS': function(){
											ExportarXLS();
										},
										Ok: function() {
											$(this).dialog('close');
										}
									}
								});	
								$('.tablesorter').tablesorter();
								$.fancybox.hideLoading();
								EdicaoAssociado();
								MostraTelefones();
								MostraEmails();
								MostraDependentes();
							},

							error: function (xhr, ajaxOptions, thrownError){
								ShowMsg(thrownError)						;
								
								//alert('Login e senha são obrigatórios');
								//$.fancybox(''+thrownError+'');		
								//alert(xhr.status);
								//alert(thrownError);
							} 
						});
					});
				},
				error: function (xhr, ajaxOptions, thrownError){
					
					ShowMsg(thrownError);
				}
			});	
		});
	}
	
	function MostraTelefones(){
		$(".busca_telefones").click(function(){
			var id_associado = jQuery(this).attr("id");
			$.ajax({ 
				
				type: 'POST',
				url: 'busca/buscar_telefones.php',
				data: {
					associado_id: id_associado
				},
				dataType: 'html',
				
				success: function(response_html){
					$('#modal_message').html(response_html),
					$('#modal_message').dialog({
						width: 'auto',
						height: 'auto',
						modal: true,
						buttons: {
							Ok: function() {
								$(this).dialog('close');
								$('#buscar').click();
							}
						}
					});		
				}
			});	
		});
	}
	
	function MostraEmails(){
		$(".busca_emails").click(function(){
			var id_associado = jQuery(this).attr("id");
			$.ajax({ 
				
				type: 'POST',
				url: 'busca/buscar_emails.php',
				data: {
					associado_id: id_associado
				},
				dataType: 'html',
				
				success: function(response_html){
					$('#modal_message').html(response_html),
					$('#modal_message').dialog({
						width: 'auto',
						height: 'auto',
						modal: true,
						buttons: {
							Ok: function() {
								$(this).dialog('close');
								$('#buscar').click();
							}
						}
					});		
				}
			});	
		});
	}	
	
	function MostraDependentes(){
		$(".busca_dependentes").click(function(){
			var id_associado = jQuery(this).attr("id");
			$.ajax({ 
				
				type: 'POST',
				url: 'busca/buscar_dependentes.php',
				data: {
					associado_id: id_associado
				},
				dataType: 'html',
				
				success: function(response_html){
					$('#modal_message').html(response_html),
					$('#modal_message').dialog({
						width: 'auto',
						height: 'auto',
						modal: true,
						buttons: {
							Ok: function() {
								$(this).dialog('close');
								$('#buscar').click();
							}
						}
					});		
				}
			});	
		});
	}
	
	function login(response){

		if(response.session == true){		
					
			//Escreve o botão de logout
			var html	= '<b>Olá '+response.nome+'!</b>';
			html		= html+'<div id="buttons_auth"><br />';
			html		= html+'<b>Data atual:</b><br /><div class="relogio"></div>';
			html		= html+'<b>Último acesso:</b><br />'+response.ultimo_login+'<br />';
			html		= html+'	<input type="button" name="cefal-rs_logout" value="Sair"  class="buttons_auth" id="button_auth_logout">';
			html		= html+'</div>';
			$('#ola').html(html);
						
			/*Relógio*/
			if($('.relogio')){

				function proximoSegundo(){
				
					var hoje = new Date();
					
					var horas = hoje.toLocaleTimeString();
					
					var dia = hoje.getDate();
					var mes = hoje.getMonth() + 1; // Mais um pois a função estava exibindo o mês anterior.
					var ano = hoje.getFullYear();
					
					if (dia < 10) {
						dia = '0' + dia;
					}
					if (mes < 10) {
						mes = '0' + mes;
					}
					
					$('.relogio').html(dia + '/' + mes + '/' + ano + ' - ' + horas);
					
				}
				
				/*Tempo de atualização do relógio*/
				setInterval(function(){
					proximoSegundo();
				}, 100);			
			}
			
			//Carrega as Abas
			
			/*
			Necessário carregar  as abas nas seguintes tags
			<div id="tabs">
			<ul>
			*/
			
			$.ajax({
				
				type: 'POST',
				url: 'adicionar/index.php',
				data: {
					session: response.session
				},
				dataType: 'html',
				
				success: function(response2_tabs2){
					
					//DatePickerToBr();
					
					$('#tabs').tabs('refresh');					
					
					$('#tabs').append(response2_tabs2);
					
					DatePickerToBr('date');
					DatePickerToBr('data_de_nascimento_dependente');
					masks();
					
					$('#tabs').tabs('refresh');		
					
					//Bloco que adiciona campos de telefones

					var smtel = -1;

					$('.addnodetelefone').on('click', function(){
												
						smtel = smtel + 1;
						
						var html =	'<div class="newnodetelefone" id="nodetel'+smtel+'">';
						html = html+'	<input type="text" class="telefones telefone" name="adicionar_telefones" style="width: 200px;" placeholder="+555132213700"/>';
						html = html+'	<div class="removethistelefone" id="remtel'+smtel+'"> -</div>';
						html = html+'</div>';
						$('.nodetelefone').append(html);
						
						removethisnodetelefone(smtel);
						
						masks();
					}); 
					function removethisnodetelefone(smtel){
					
						$('#remtel'+smtel).click(function(){
							$('#nodetel'+smtel).remove();
						});
					}

					//Bloco que adiciona campos de emails

					var smmail = -1;

					$('.addnodeemail').on('click', function(){
												
						smmail = smmail + 1;
						
						var html =	'<div class="newnodeemail" id="nodemail'+smmail+'">';
						html = html+'	<input type="text" class="emails email" name="adicionar_emails" style="width: 400px;" placeholder="e-mail@dominio.tld"/>';
						html = html+'	<div class="removethisemail" id="remmail'+smmail+'"> -</div>';
						html = html+'</div>';
						$('.nodeemail').append(html);
						
						removethisnodeemail(smmail);
					});
					function removethisnodeemail(smmail){
					
						$('#remmail'+smmail).click(function(){
							$('#nodemail'+smmail).remove();
						});
					}
					
					//Bloco que adiciona campos de dependentes

					var smdep = 0;

					$('.addnodedependente').on('click', function(){
												
						smdep = smdep + 1;
						
						var	html =  '<div class="newnodedependente" id="nodedep'+smdep+'">';
						html = html+'	<div class="form_campos_medios">';
						html = html+'	<span>Nome</span><br/>';
						html = html+'		<input type="text" name="adicionar_nomes_dependentes" class="nomes_dependentes" style="width: 400px;" value=""/>';
						html = html+'	</div>';
						html = html+'	<div class="form_campos_curtos">';
						html = html+'		<span>Data de nascimento</span>';
						html = html+'		<br/>';
						html = html+'		<input type="text" name="adicionar_datas_de_nascimentos_dependentes" class="datas_de_nascimentos_dependentes date" style="width: 200px;" value="" placeholder="__/__/____" />';
						html = html+'		<div class="removethisdependente" id="remdep'+smdep+'"> -</div>';
						html = html+'	</div>';
						html = html+'</div>';
						$('.nodedependente').append(html);
						
						removethisnodependente(smdep);	
						
						DatePickerToBr('datas_de_nascimentos_dependentes');
						
						masks();
					}); 
					function removethisnodependente(smdep){
					
						$('#remdep'+smdep).click(function(){
							$('#nodedep'+smdep).remove();
						});
					}
					
					Gravar();
					
					BuscarComEdicao();
					
				}
			});
			
			$.ajax({
				
				type: 'POST',
				url: 'config/index.php',
				data: {
					session: response.session
				},
				dataType: 'html',
				
				success: function(response3_tabs3){
					
					$('#tabs ul').append('<li><a href="#tabs-2">Adicionar</a></li>');
					$('#tabs ul').append('<li><a href="#tabs-3">Administração</a></li>');
					$('#tabs').tabs('refresh');					
					
					$('#tabs').append(response3_tabs3);
					
					$("#tabs").tabs("refresh");
					
					ListarAdministradores(response);
					
					AdicionarAdministrador(response);
										
				}
			});			
			
		}else{
			alert('Login inválido!');
		}
	}
	
	function logout(){
		$('#button_auth_logout').click(function(){		
			//alert('teste');
			
			var response = new Object();
			response.session = false;
			response = JSON.stringify(response);

			$.ajax({
				type: 'POST',
				url: 'busca/index.php',
				dataType: 'html',
				beforeSend: function() { 
					$.fancybox.showLoading();
				},
				success: function(response){
					$('#site').html(response);

					//Escreve o botão de login
					var html = '<b>Olá visitante!</b>';					
					html = html+'<div id="session"></div>';
					html = html+'<span>Login</span>';
					html = html+'<br>';
					html = html+'<input type="text" name="cefal-rs_usuario" id="cefal-rs_usuario" width="100px" />';
					html = html+'<br>';
					html = html+'<span>Senha</span> ';
					html = html+'<br>';
					html = html+'<input type="password" name="cefal-rs_senha" id="cefal-rs_senha" width="100px" />';
					html = html+'<div id="buttons_auth">';
					html = html+'	<input type="button" name="cefal-rs_login" value="Entrar" class="buttons_auth" id="buttons_auth_login">';
					html = html+'</div>';
					$('div#ola').html(html);
					
					CallLogin();
					
					Buscar();
					
					$("#tabs").tabs();
					
					$.fancybox.hideLoading();
					
					EnterLogin();
					
					$("#marcar_desmarcar").click(function(){
						$('input[type=checkbox]').each(function () {
							  this.checked = !this.checked;
						});
					});
					
				},
				error: function (xhr, ajaxOptions, thrownError){
					$.fancybox.hideLoading();
					alert('Login e senha são obrigatórios');
					//$.fancybox(''+thrownError+'');		
					//alert(xhr.status);
					//alert(thrownError);
				}
			});
		});
	}
	
	function CallLogin(){
		$('#buttons_auth_login').click(function(){
			//alert('teste');
			$.ajax({
				type: 'POST',
				url: 'login/index.php',
				data: {
					usuario: $('#cefal-rs_usuario').val(),
					senha: $('#cefal-rs_senha').val()
				},
				dataType: 'json',
				beforeSend: function() { 
					$.fancybox.showLoading();
				},
				success: function(response){	
					login(response);
					logout();
					$.fancybox.hideLoading();
				},
				error: function (xhr, ajaxOptions, thrownError){
					$.fancybox.hideLoading();
					alert('Login e senha são obrigatórios');
					//$.fancybox(''+thrownError+'');		
					//alert(xhr.status);
					//alert(thrownError);
				}
			});
		});			
	}
	
	CallLogin();
	
	Buscar();
	
	EnterLogin();
	
	$("#marcar_desmarcar").click(function(){
		$('input[type=checkbox]').each(function () {
			  this.checked = !this.checked;
		});
	});
	
	/*
	$.ajax({
	Manter este exemplo para consulta.
		type: 'POST',
		url: 'php/teste.php',
		data: {
			data: 'ççç3'
		},
		dataType: 'html',
		
		success: function(response){
			$('div.conteudo').html(response);			
		}
	});	
	*/
});
