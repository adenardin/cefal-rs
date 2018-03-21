<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if($_POST['session'] == true){
			$id_associado = $_POST['associado'];
			include_once('../conexao.php');
			
			$sql_busca_usuario = '
				SELECT 
					`cefal-rs_associados`.`cefal-rs_associado_matricula`,
					`cefal-rs_associados`.`cefal-rs_categoria_id`,
					`cefal-rs_associados`.`cefal-rs_setor_id`,
					`cefal-rs_associados`.`cefal-rs_coordenadoria_id`,
					`cefal-rs_associados`.`cefal-rs_associado_nome`,
					`cefal-rs_associados`.`cefal-rs_associado_rg`,
					`cefal-rs_associados`.`cefal-rs_associado_cpf`,
					DATE_FORMAT(`cefal-rs_associados`.`cefal-rs_associado_data_nascimento`,"%d/%m/%Y") AS `cefal-rs_associado_data_nascimento`,
					
					`cefal-rs_enderecos`.`cefal-rs_endereco_cep`,
					`cefal-rs_enderecos`.`cefal-rs_municipio_id`,
					`cefal-rs_enderecos`.`cefal-rs_endereco_bairro`,
					`cefal-rs_enderecos`.`cefal-rs_endereco_logradouro`,
					
					`cefal-rs_bancos`.`cefal-rs_banco_nome`,
					`cefal-rs_bancos`.`cefal-rs_banco_agencia`,
					`cefal-rs_bancos`.`cefal-rs_banco_conta`,
					
					REPLACE(`cefal-rs_contabilidade`.`cefal-rs_contabilidade_salario`, ".", ",") AS `cefal-rs_contabilidade_salario`,
					REPLACE(`cefal-rs_contabilidade`.`cefal-rs_contabilidade_credito`, ".", ",") AS `cefal-rs_contabilidade_credito`,
					REPLACE(`cefal-rs_contabilidade`.`cefal-rs_contabilidade_credito_usado`, ".", ",") AS `cefal-rs_contabilidade_credito_usado`,					
					
					`cefal-rs_gabinetes`.`cefal-rs_gabinete_nome`

					FROM `cefal-rs_associados` 
					LEFT JOIN `cefal-rs_enderecos` ON `cefal-rs_enderecos`.`cefal-rs_associado_id` = `cefal-rs_associados`.`cefal-rs_associado_id`
					LEFT JOIN `cefal-rs_bancos` ON `cefal-rs_bancos`.`cefal-rs_associado_id` = `cefal-rs_associados`.`cefal-rs_associado_id`
					LEFT JOIN `cefal-rs_contabilidade` ON `cefal-rs_contabilidade`.`cefal-rs_associado_id` = `cefal-rs_associados`.`cefal-rs_associado_id`
					LEFT JOIN `cefal-rs_gabinetes` ON `cefal-rs_gabinetes`.`cefal-rs_gabinete_id` = `cefal-rs_associados`.`cefal-rs_gabinete_id`
					LEFT JOIN `cefal-rs_categorias` ON `cefal-rs_categorias`.`cefal-rs_categoria_id` = `cefal-rs_associados`.`cefal-rs_categoria_id`
					LEFT JOIN `cefal-rs_setores` ON `cefal-rs_setores`.`cefal-rs_setor_id` = `cefal-rs_associados`.`cefal-rs_setor_id`
					WHERE `cefal-rs_associados`.`cefal-rs_associado_id` = '.$id_associado.'
				;
			'; 
			
			$query_usuario = mysql_query($sql_busca_usuario, $conn);
			
			while($var_retorno = mysql_fetch_array($query_usuario)){
				$numero_dependentes = 0;
				$numero_telefones = 0;
				$numero_emails = 0;
				
				$html = '
					<div id="tabs-5" class="tabs">
						<br />
						<h3>Pessoais</h3>
						<div class="form_campos_longos">						
							<span>Nome</span>
							<br />
							<input type="text" name="atualizar_nome" value="'.$var_retorno["cefal-rs_associado_nome"].'" style="width: 900px;"/>
						</div>
						<div class="form_campos_longos">							
							<span>Endereço</span>
							<br />
							<input type="text" name="atualizar_logradouro" style="width: 900px;" value="'.$var_retorno["cefal-rs_endereco_logradouro"].'" />
						</div>
						<div class="form_campos">
							<div class="form_campos_curtos">
								<span>RG</span>
								<br>
								<input type="text" name="atualizar_rg" style="width: 200px;" value="'.$var_retorno["cefal-rs_associado_rg"].'"/>
							</div>
							<div class="form_campos_curtos">
								<span>CPF</span>
								<br>
								<input type="text" name="atualizar_cpf" style="width: 200px;" value="'.$var_retorno["cefal-rs_associado_cpf"].'"/>
							</div>
							<div class="form_campos_curtos">						
								<span>Data de nascimento</span>
								<br/>
								<input type="text" name="atualizar_data_de_nascimento" style="width: 200px;" value="'.$var_retorno["cefal-rs_associado_data_nascimento"].'" class="date"/>
							</div>						
						</div>
						<div class="form_campos">
							<div class="form_campos_curtos">
								<span>CEP</span>
								<br/>
								<input type="text" name="atualizar_cep" style="width: 200px;" value="'.$var_retorno["cefal-rs_endereco_cep"].'"/>
							</div>
							<div class="form_campos_curtos">
								<span>Municípios</span>
								<br/>
								<select name="atualizar_municipio">
									<option value="0">Nenhum</option>';	
								
									$sql2 = '
									
										SELECT 

										`cefal-rs_municipio_id`,
										`cefal-rs_municipio`,
										`cefal-rs_municipio_criacao`, 
										`cefal-rs_municipio_edicao`, 
										`cefal-rs_administrador_id`, 
										`cefal-rs_municipio_status`

										FROM `cefal-rs_municipios`;
									';
									$query2 = mysql_query($sql2, $conn);
									
									while($var2 = mysql_fetch_array($query2)){
										if($var2['cefal-rs_municipio_id'] == $var_retorno["cefal-rs_municipio_id"]){
											$html .= '<option value="'.$var2['cefal-rs_municipio_id'].'" selected="true">'.$var2['cefal-rs_municipio'].'</option>';
										}
										else{
											$html .= '<option value="'.$var2['cefal-rs_municipio_id'].'">'.$var2['cefal-rs_municipio'].'</option>';
										}
									}
									$html .= '
								</select>							
							</div>
							<div class="form_campos_curtos">						
								<span>Bairro</span>
								<br/>
								<input type="text" name="atualizar_bairro" style="width: 200px;" value="'.$var_retorno["cefal-rs_endereco_bairro"].'"/>
							</div>						
						</div>
						<div class="form_campos">
							<div class="form_campos_curtos">					
								<span>Telefones</span>';	

									$sql = 'SELECT `cefal-rs_telefone` FROM `cefal-rs_telefones` WHERE `cefal-rs_tabela_id` = '.$id_associado;
									$query = mysql_query($sql, $conn);
									
									$totalRows = mysql_num_rows($query);
									if($totalRows == 0){
										$html .= '<div class="nodetelefone" id="nodetel">
													<input type="text" name="atualizar_telefones" class="telefones" style="width: 200px; " placeholder="+555132213700" title="Mantenha o padrão sugerido para melhor utilização" value="" />
													<div class="addnodetelefone">+</div>
													<br/>
												</div>';
									}
									else{
										while($var = mysql_fetch_array($query)){
											if($numero_telefones == 0){
												$html .= '<div class="nodetelefone" id="nodetel'.$numero_telefones.'">
															<input type="text" name="atualizar_telefones" class="telefones" style="width: 200px; " placeholder="+555132213700" title="Mantenha o padrão sugerido para melhor utilização" value="'.$var["cefal-rs_telefone"].'" />
															<div class="addnodetelefone">+</div>
															<br/>
														</div>';
											}
											else{
												$html .= '<div class="newnodetelefone" id="nodetel'.$numero_telefones.'">
															<input type="text" name="atualizar_telefones" class="telefones" style="width: 200px; " placeholder="+555132213700" title="Mantenha o padrão sugerido para melhor utilização" value="'.$var["cefal-rs_telefone"].'" />
															<div class="removethistelefone" id="remtel'.$numero_telefones.'" linha="'.$numero_telefones.'"> -</div>
															<br/>
														</div>';
											}
											$numero_telefones++;
										}
								
									}
								
								
						$html .= '</div>
						</div>
						<div class="form_campos">
							<div class="form_campos_medios">					
								<span>E-mails</span>';	

									$sql = 'SELECT `cefal-rs_email` FROM `cefal-rs_emails` WHERE `cefal-rs_tabela_id` = '.$id_associado;
									$query = mysql_query($sql, $conn);
									
									$totalRows = mysql_num_rows($query);
									if($totalRows == 0){
										$html .= '<div class="nodeemail" id="nodemail">
													<input type="text" name="atualizar_emails" class="emails" style="width: 400px; " placeholder="e-mail@dominio.tld" title="Mantenha o padrão sugerido para melhor utilização" value="" />
													<div class="addnodeemail">+</div>
													<br/>
												</div>';
									}
									else{
										while($var = mysql_fetch_array($query)){
											if($numero_emails == 0){
												$html .= '<div class="nodeemail" id="nodemail'.$numero_emails.'">
															<input type="text" name="atualizar_emails" class="emails" style="width: 400px; " placeholder="e-mail@dominio.tld" title="Mantenha o padrão sugerido para melhor utilização" value="'.$var["cefal-rs_email"].'" />
															<div class="addnodeemail">+</div>
															<br/>
														</div>';
											}
											else{
												$html .= '<div class="newnodeemail" id="nodemail'.$numero_emails.'">
															<input type="text" name="atualizar_emails" class="emails" style="width: 400px; " placeholder="e-mail@dominio.tld" title="Mantenha o padrão sugerido para melhor utilização" value="'.$var["cefal-rs_email"].'" />
															<div class="removethisemail" id="remmail'.$numero_emails.'" linha="'.$numero_emails.'"> -</div>
															<br/>
														</div>';
											}
											$numero_emails++;
										}
								
									}
								
								
						$html .= '</div>
						</div>
						<div class="form_campos">					
							<h3>Dependentes</h3>
							';
									$sql = '
										SELECT 
											`cefal-rs_dependente_nome`,
											DATE_FORMAT(`cefal-rs_dependente_data_nascimento`,"%d/%m/%Y") AS `cefal-rs_dependente_data_nascimento`
											FROM `cefal-rs_dependentes` 
											WHERE `cefal-rs_associado_id` = '.$id_associado.'
										;
									';
									$query = mysql_query($sql, $conn);
									
									$totalRows = mysql_num_rows($query);
									if($totalRows == 0){
										$html .= '
										<div class="nodedependente" id="nodedep">
											<div class="form_campos_medios">
												<span>Nome</span>
												<br />
												<input type="text" name="atualizar_nomes_dependentes" class="nomes_dependentes" style="width: 400px;" value=""/>
											</div>
											<div class="form_campos_curtos">
												<span>Data de Nascimento</span>
												<br />
												<input type="text" name="atualizar_datas_de_nascimentos_dependentes" class="data_de_nascimento_dependente" placeholder="99/99/9999" style="width: 200px;" value=""/>
												<div class="addnodedependente">+</div>
											</div>
										</div>';
									}
									else{
										while($var = mysql_fetch_array($query)){
											if($numero_dependentes == 0){
												$html .= '
												<div class="nodedependente" id="nodedep'.$numero_dependentes.'">
													<div class="form_campos_medios">
														<span>Nome</span>
														<br />
														<input type="text" name="atualizar_nomes_dependentes" class="nomes_dependentes" style="width: 400px;" value="'.$var["cefal-rs_dependente_nome"].'"/>
													</div>
													<div class="form_campos_curtos">
														<span>Data de Nascimento</span>
														<br />
														<input type="text" name="atualizar_datas_de_nascimentos_dependentes" class="data_de_nascimento_dependente" placeholder="99/99/9999" style="width: 200px;" value="'.$var["cefal-rs_dependente_data_nascimento"].'"/>
														<div class="addnodedependente">+</div>
													</div>
												</div>';
											}
											else{
												$html .= '
												<div class="newnodedependente"  id="nodedep'.$numero_dependentes.'">
													<div class="form_campos_medios">
														<span>Nome</span>
														<br />
														<input type="text" name="atualizar_nomes_dependentes" class="nomes_dependentes" style="width: 400px;" value="'.$var["cefal-rs_dependente_nome"].'"/>
													</div>
													<div class="form_campos_curtos">
														<span>Data de Nascimento</span>
														<br />
														<input type="text" name="atualizar_datas_de_nascimentos_dependentes" class="data_de_nascimento_dependente" style="width: 200px;" value="'.$var["cefal-rs_dependente_data_nascimento"].'"/>
														<div class="removethisdependente" id="remdep'.$numero_dependentes.'" linha="'.$numero_dependentes.'"> -</div>
													</div>
												</div>';
											}
											$numero_dependentes++;
										}
									}
						$html .= '</div>
						<div class="form_campos">
							<h3>Contabeis</h3>		
							<div class="form_campos_curtos">
								<span>Banco</span>
								<br/>
								<input type="text" name="atualizar_banco" style="width: 200px;" value="'.$var_retorno["cefal-rs_banco_nome"].'"/>
							</div>
							<div class="form_campos_curtos">
								<span>Agencia</span>
								<br>
								<input type="text" name="atualizar_agencia" style="width: 200px;" value="'.$var_retorno["cefal-rs_banco_agencia"].'"/>
							</div>
							<div class="form_campos_curtos">
								<span>Conta</span>
								<br>
								<input type="text" name="atualizar_conta" style="width: 200px;" value="'.$var_retorno["cefal-rs_banco_conta"].'"/>							
							</div>
							<div class="form_campos_curtos">
								<span>Salario</span>
								<br/>
								<input type="text" name="atualizar_salario" style="width: 200px;" value="'.$var_retorno["cefal-rs_contabilidade_salario"].'"/>
							</div>
							<div class="form_campos_curtos">
								<span>Limite de Credito</span>
								<br>
								<input type="text" name="atualizar_limite_credito" style="width: 200px;" value="'.$var_retorno["cefal-rs_contabilidade_credito"].'"/>
							</div>
							<div class="form_campos_curtos">
								<span>Limite usado</span>
								<br>
								<input type="text" name="atualizar_limite_usado" style="width: 200px;" value="'.$var_retorno["cefal-rs_contabilidade_credito_usado"].'"/>							
							</div>						
						</div>				
						<div class="form_campos">
							<h3>Dados AL</h3>
							<div class="form_campos_curtos">
								<span>Matricula</span>
								<br/>
								<input type="text" name="atualizar_matricula" style="width: 200px;" value="'.$var_retorno["cefal-rs_associado_matricula"].'"/>
							</div>
							<div class="form_campos_curtos">
								<span>Gabinete</span>
								<br/>
								<input type="text" name="atualizar_gabinete" style="width: 200px;" value="'.$var_retorno["cefal-rs_gabinete_nome"].'"/>
							</div>
						</div>
						<div class="form_campos">
							<div class="form_campos_select">
								<span>Categoria</span>
								<br />
								<select name="atualizar_categoria" id="atualizar_categoria">
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
										if($var['cefal-rs_categoria_id'] == $var_retorno["cefal-rs_categoria_id"]){
											$html .= '<option value="'.$var['cefal-rs_categoria_id'].'" selected="true">'.$var['cefal-rs_categoria_nome'].'</option>';
										}
										else{
											$html .= '<option value="'.$var['cefal-rs_categoria_id'].'">'.$var['cefal-rs_categoria_nome'].'</option>';
										}
									}
									$html .= '
								</select>							
							</div>
							<div class="form_campos_select">
								<span>Setor</span>
								<br />
								<select name="atualizar_setor" id="atualizar_setor">
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
										if($var['cefal-rs_setor_id'] == $var_retorno["cefal-rs_setor_id"]){
											$html .= '<option value="'.$var['cefal-rs_setor_id'].'" selected="true">'.$var['cefal-rs_setor_nome'].'</option>';
										}
										else{
											$html .= '<option value="'.$var['cefal-rs_setor_id'].'">'.$var['cefal-rs_setor_nome'].'</option>';
										}
									}
									
									$html .= '
								</select>
							</div>
							<div class="form_campos_select">
								<span>Coordenadoria</span>
								<br />
								<select name="atualizar_coordenadoria" id="atualizar_coordenadoria">
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
										if($var['cefal-rs_partido_id'] == $var_retorno["cefal-rs_coordenadoria_id"]){
											$html .= '<option value="'.$var['cefal-rs_partido_id'].'" selected="true">'.$var['cefal-rs_partido_sigla'].'</option>';
										}
										else{
											$html .= '<option value="'.$var['cefal-rs_partido_id'].'">'.$var['cefal-rs_partido_sigla'].'</option>';
										}
									}
									$html .= '
								</select>
							</div>		 
						</div>
						<div align="right">
							<input type="button" Value="Atualizar" id="atualiza_associado" class="adicionar"/>						
						  <input type="button" value="Cancelar" id="cancela_associado" class="cancelar">
						</div>					
					</div>
				';
				$vetor = array('retorno_html'=>$html, 'telefones' => $numero_telefones, 'emails' => $numero_emails,  'dependentes' => $numero_dependentes);
				echo json_encode($vetor);
			}
		}
	}
?>
