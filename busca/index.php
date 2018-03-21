<?php
	/*
		BUSCAR
		cefal-rs/busca/index.php	
	*/
	include_once('../conexao.php');
?>
<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Busca</a></li>
	</ul>
	<div id="tabs-1" class="tabs">
			<div class="form_campos_longos">
				<span>Nome</span>
				<br />
				<input type="text" name="nome" style="width: 900px;" value="" />
			</div>
			<div class="form_campos">
				<br />
				<div class="form_campos_curtos">
					<span>Matricula</span>
					<br/>
					<input type="text" name="matricula" style="width: 200px;" value=""/>
				</div>
				<div class="form_campos_curtos">
					<span>CEP</span>
					<br>
					<input type="text" class="cep" name="cep" style="width: 200px;" value="" placeholder="99999-999" />
				</div>
				<div class="form_campos_curtos">
					<span>Gabinete</span>
					<br>
					<input type="text" name="gabinete" style="width: 200px;" value=""/>
				</div>
			</div>
			<div class="form_campos">
				<div id="form_coordenadorias" class="form_campos_curtos_aba_busca">
					<span>Coordenadoria</span>
					<br />
					<select name="coordenadoria">
						<option value="0">Nenhuma</option>';
						<?php
						
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
						?>
					</select>
				</div>
				<div id="form_categorias" class="form_campos_curtos_aba_busca">
					<span>Categoria</span>
					<br />
					<select name="categoria">
						<option value="0">Nenhuma</option>
						<?php
						
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
						?>
					</select>
				</div>
				<div id="form_setores" class="form_campos_curtos_aba_busca">
					<span>Setor</span>
					<br />
					<select name="setor">
						<option value="0">Nenhum</option>
						<?php
						
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
						?>
					</select>
				</div>	
				<div id="form_setores" class="form_campos_curtos_aba_busca">
					<span>Municípios</span>
					<br />
					<select name="municipio">
						<option value="0">Nenhum</option>
						<?php
							$sql = '
								SELECT 
									`cefal-rs_municipio_id`, 
									`cefal-rs_municipio` 
								FROM `cefal-rs_municipios`;
							';
							$query = mysql_query($sql, $conn);
							
							while($var = mysql_fetch_array($query)){
								echo '<option value="'.$var['cefal-rs_municipio_id'].'">'.$var['cefal-rs_municipio'].'</option>';
							}
						?>
					</select>
				</div>	
			</div>
			<br />
			<div class="form_dados_retorno">		
				<h3>Dados Retorno</h3>
				<hr>
				<div class="form_campos_curtos">
					<u>Pessoais</u>
					<br />
					<div class="form_checkbox">
						<span ><input type="checkbox" name="retorno_busca[]" value="matricula" /> Matricula</span>
						<br />
						<span><input type="checkbox" name="retorno_busca[]" value="nome" /> Nome</span>					
						<br/>
						<span><input type="checkbox" name="retorno_busca[]" value="rg" /> RG</span>
						<br />
						<span><input type="checkbox" name="retorno_busca[]" value="cpf"/> CPF</span>
						<br />
						<span><input type="checkbox" name="retorno_busca[]" value="data_nascimento"/> Data Nascimento</span>						
					</div>				
					<div class="form_checkbox">
						<span><input type="checkbox" name="retorno_busca[]" value="endereco" /> Endereço</span>
						<br />
						<span><input type="checkbox" name="retorno_busca[]" value="cep" /> CEP</span>
						<br />
						<span><input type="checkbox" name="retorno_busca[]" value="telefones"/> Telefones</span>
						<br />
						<span><input type="checkbox" name="retorno_busca[]" value="emails"/> E-mails</span>
						<br />
						<span><input type="checkbox" name="retorno_busca[]" value="dependentes" /> Dependentes</span>
					</div>
				</div>
				<div class="form_campos_curtos">
					<u>Contábeis</u>
					<br />
					<div class="form_checkbox">
						<span ><input type="checkbox" name="retorno_busca[]" value="salario"> Salário</span>
						<br/>
						<span ><input type="checkbox" name="retorno_busca[]" value="banco" /> Banco</span>
						<br />
						<span ><input type="checkbox" name="retorno_busca[]" value="agencia" /> Agência</span>						
						<br/>						
						<span ><input type="checkbox" name="retorno_busca[]" value="conta" /> Conta</span>
					</div>
					<div class="form_checkbox">
						<span ><input type="checkbox" name="retorno_busca[]" value="limite_de_credito" /> Limite de Crédito</span>
						<br/>
						<span ><input type="checkbox" name="retorno_busca[]" value="limite_usado" /> Limite Usado</span>
						<br/>
						<span ><input type="checkbox" name="retorno_busca[]" value="limite_atual" /> Limite Atual</span>
					</div>		
				</div>
				<div class="form_campos_curtos">
					<u>Dados AL</u>
					<br />
					<div class="form_checkbox">
						<span ><input type="checkbox" name="retorno_busca[]" value="setor" /> Setor</span>
						<br/>
						<span ><input type="checkbox" name="retorno_busca[]" value="gabinete" /> Gabinete</span>
					</div>
					<div class="form_checkbox">					
						<span ><input type="checkbox" name="retorno_busca[]" value="categoria" /> Categoria</span>
						<br/>
						<span ><input type="checkbox" name="retorno_busca[]" value="coordenadoria" /> Coordenadoria</span>
					</div>				
				</div>				
			</div>
			<div align="right">
				<input type="button" Value="Marcar/Desmarcar" id="marcar_desmarcar"  />&nbsp;&nbsp;&nbsp;
				<input type="button" Value="Buscar" id="buscar" />
			</div>
		</div>				
	</div>
</div>
