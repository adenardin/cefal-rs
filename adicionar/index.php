<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if($_POST['session'] == true){
			include_once('../conexao.php');
			echo '
				<div id="tabs-2" class="tabs">
					<br />
					<h3>Pessoais</h3>
					<div class="form_campos_longos">						
						<span>Nome</span>
						<br />
						<input type="text" name="adicionar_nome" value="" style="width: 900px;"/>
					</div>
					<div class="form_campos_longos">							
						<span>Endereço</span>
						<br />
						<input type="text" name="adicionar_logradouro" style="width: 900px;" value="" />
					</div>
					<div class="form_campos">
						<div class="form_campos_curtos">
							<span>RG</span>
							<br>
							<input type="text" name="adicionar_rg" class="rg" style="width: 200px;" value="" placeholder="1234567890" />
						</div>
						<div class="form_campos_curtos">
							<span>CPF</span>
							<br>
							<input type="text" name="adicionar_cpf" class="cpf" style="width: 200px;" value="" placeholder="___.___.___-__" />
						</div>
						<div class="form_campos_curtos">						
							<span>Data de nascimento</span>
							<br/>
							<input type="text" name="adicionar_data_de_nascimento" style="width: 200px;" value="" class="date" placeholder="__/__/____" />
						</div>						
					</div>
					<div class="form_campos">
						<div class="form_campos_curtos">
							<span>CEP</span>
							<br/>
							<input type="text" name="adicionar_cep" class="cep" style="width: 200px;" value="" placeholder="_____-___" />
						</div>
						<div class="form_campos_curtos">
							<span>Municípios</span>
							<br/>
							<select name="adicionar_municipio">
								<option value="0">Nenhum</option>';	
								// TRECHO EM PHP							
								/*
								
								Campos da tabela categorias
								
								`cefal-rs_municipio_id`,
								`cefal-rs_municipio`,
								`cefal-rs_municipio_criacao`, 
								`cefal-rs_municipio_edicao`, 
								`cefal-rs_administrador_id`, 
								`cefal-rs_municipio_status`
								
								*/
							
								$sql = '
								
									SELECT 

									`cefal-rs_municipio_id`,
									`cefal-rs_municipio`,
									`cefal-rs_municipio_criacao`, 
									`cefal-rs_municipio_edicao`, 
									`cefal-rs_administrador_id`, 
									`cefal-rs_municipio_status`

									FROM `cefal-rs_municipios`;
								';
								$query = mysql_query($sql, $conn);
								
								while($var = mysql_fetch_array($query)){
									echo '<option value="'.$var['cefal-rs_municipio_id'].'">'.$var['cefal-rs_municipio'].'</option>';
								}
								echo '
							</select>							
						</div>
						<div class="form_campos_curtos">						
							<span>Bairro</span>
							<br/>
							<input type="text" name="adicionar_bairro" style="width: 200px;" value=""/>
						</div>						
					</div>
					<div class="form_campos">
						<div class="form_campos_curtos">					
							<span>Telefones</span>					
							<div class="nodetelefone">
								<input type="text" name="adicionar_telefones" class="telefones telefone" style="width: 200px; " placeholder="+555132213700" title="Mantenha o padrão sugerido para melhor utilização" />
								<div class="addnodetelefone">+</div>
								<br/>
							</div>
						</div>
					</div>
					<div class="form_campos">
						<div class="form_campos_medios">					
							<span>E-mails</span>					
							<div class="nodeemail">
								<input type="text" name="adicionar_emails" class="emails email" style="width: 400px; " placeholder="e-mail@dominio.tld" title="Mantenha o padrão sugerido para melhor utilização" />
								<div class="addnodeemail">+</div>
								<br/>
							</div>
						</div>
					</div>
					<div class="form_campos">					
						<h3>Dependentes</h3>
						<div class="nodedependente">
							<div class="form_campos_medios">
								<span>Nome</span>
								<br />
								<input type="text" name="adicionar_nomes_dependentes" class="nomes_dependentes" style="width: 400px;" value=""/>
							</div>
							<div class="form_campos_curtos">
								<span>Data de Nascimento</span>
								<br />
								<input type="text" name="adicionar_datas_de_nascimentos_dependentes" class="data_de_nascimento_dependente date" style="width: 200px;" value="" placeholder="__/__/____" />
								<div class="addnodedependente">+</div>
							</div>
						</div>
					</div>
					<div class="form_campos">
						<h3>Contabeis</h3>		
						<div class="form_campos_curtos">
							<span>Banco</span>
							<br/>
							<input type="text" name="adicionar_banco" style="width: 200px;" value=""/>
						</div>
						<div class="form_campos_curtos">
							<span>Agencia</span>
							<br>
							<input type="text" name="adicionar_agencia" style="width: 200px;" value=""/>
						</div>
						<div class="form_campos_curtos">
							<span>Conta</span>
							<br>
							<input type="text" name="adicionar_conta" style="width: 200px;" value=""/>							
						</div>
						<div class="form_campos_curtos">
							<span>Salario</span>
							<br/>
							<input type="text" name="adicionar_salario" style="width: 200px;" value=""/>
						</div>
						<div class="form_campos_curtos">
							<span>Limite de Credito</span>
							<br>
							<input type="text" name="adicionar_limite_credito" style="width: 200px;" value=""/>
						</div>
						<div class="form_campos_curtos">
							<span>Limite usado</span>
							<br>
							<input type="text" name="adicionar_limite_usado" style="width: 200px;" value=""/>							
						</div>						
					</div>				
					<div class="form_campos">
						<h3>Dados AL</h3>
						<div class="form_campos_curtos">
							<span>Matricula</span>
							<br/>
							<input type="text" name="adicionar_matricula" style="width: 200px;" value=""/>
						</div>
						<div class="form_campos_curtos">
							<span>Gabinete</span>
							<br/>
							<input type="text" name="adicionar_gabinete" style="width: 200px;" value=""/>
						</div>
					</div>
					<div class="form_campos">
						<div class="form_campos_select">
							<span>Categoria</span>
							<br />
							<select name="adicionar_categoria" id="adicionar_categoria">
								<option value="0">Nenhuma</option>';	
								// TRECHO EM PHP							
								/*
								
								Campos da tabela categorias
								
								`cefal-rs_categoria_id`, 
								`cefal-rs_categoria_nome`, 
								`cefal-rs_categoria_data_criacao`, 
								`cefal-rs_categoria_data_edicao`, 
								`cefal-rs_administrador_id`, 
								`cefal-rs_categoria_status`
								
								*/
							
								$sql = '
								
									SELECT 

										`cefal-rs_categoria_id`, 
										`cefal-rs_categoria_nome`

									FROM `cefal-rs_categorias`;
								';
								$query = mysql_query($sql, $conn);
								
								while($var = mysql_fetch_array($query)){
									echo '<option value="'.$var['cefal-rs_categoria_id'].'">'.$var['cefal-rs_categoria_nome'].'</option>';
								}
								echo '
							</select>							
						</div>
						<div class="form_campos_select">
							<span>Setor</span>
							<br />
							<select name="adicionar_setor" id="adicionar_setor">
								<option value="0">Nenhum</option>';
									
								// TRECHO EM PHP
								/*
								
								Campos da tabela setores
								
								`cefal-rs_setor_id`, 
								`cefal-rs_setor_nome`, 
								`cefal-rs_setor_data_criacao`, 
								`cefal-rs_setor_data_edicao`, 
								`cefal-rs_administrador_id`, 
								`cefal-rs_setor_status`
								
								*/
							
								$sql = '
									SELECT 

										`cefal-rs_setor_id`, 
										`cefal-rs_setor_nome`

									FROM `cefal-rs_setores`;
								';
								$query = mysql_query($sql, $conn);
								
								while($var = mysql_fetch_array($query)){
									echo '<option value="'.$var['cefal-rs_setor_id'].'">'.$var['cefal-rs_setor_nome'].'</option>';
								}
								
								echo '
							</select>
						</div>
						<div class="form_campos_select">
							<span>Coordenadoria</span>
							<br />
							<select name="adicionar_coordenadoria" id="adicionar_coordenadoria">
								<option value="0">Nenhuma</option>';
								//TRECHO EM PHP
								
								/*
								
								Campos da tabela coordenadorias
								
									`cefal-rs_partido_id`,
									`cefal-rs_partido_nome`, 
									`cefal-rs_partido_sigla`, 
									`cefal-rs_partido_data_criacao`,
									`cefal-rs_partido_data_edicao`, 
									`cefal-rs_administrador_id`, 
									`cefal-rs_partido_status`							
								*/
							
								$sql = '
									SELECT 

										`cefal-rs_partido_id`,
										`cefal-rs_partido_sigla`

									FROM `cefal-rs_partidos`;
								';
								$query = mysql_query($sql, $conn);
								
								while($var = mysql_fetch_array($query)){
									echo '<option value="'.$var['cefal-rs_partido_id'].'">'.$var['cefal-rs_partido_sigla'].'</option>';
								}
								echo '
							</select>
						</div>		
					</div>
					<div align="right">
						<input type="button" Value="Adicionar" id="associado" class="adicionar"/>						
					</div>						
				</div>
			';
		}
	}
?>
