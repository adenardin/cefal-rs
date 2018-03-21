CREATE OR REPLACE VIEW `view_retorno` AS 
SELECT
	`cefal-rs`.`cefal-rs_associados`.`cefal-rs_associado_id` 					AS `retorno_id`,
	`cefal-rs`.`cefal-rs_associados`.`cefal-rs_associado_matricula` 			AS `retorno_matricula`,
	`cefal-rs`.`cefal-rs_associados`.`cefal-rs_associado_nome` 					AS `retorno_nome`,
	`cefal-rs`.`cefal-rs_associados`.`cefal-rs_associado_data_nascimento` 		AS `retorno_data_nascimento`,
	`cefal-rs`.`cefal-rs_associados`.`cefal-rs_associado_rg` 					AS `retorno_rg`,
	`cefal-rs`.`cefal-rs_associados`.`cefal-rs_associado_cpf` 					AS `retorno_cpf`,
	`cefal-rs`.`cefal-rs_associados`.`cefal-rs_associado_foto` 					AS `retorno_foto`,
	`cefal-rs`.`cefal-rs_associados`.`cefal-rs_coordenadoria_id` 				AS `retorno_associado_coordenadoria_id`,
	`cefal-rs`.`cefal-rs_associados`.`cefal-rs_gabinete_id` 					AS `retorno_gabinete_id`,
	`cefal-rs`.`cefal-rs_associados`.`cefal-rs_setor_id` 						AS `retorno_setor_id`,
	`cefal-rs`.`cefal-rs_associados`.`cefal-rs_banco_id` 						AS `retorno_banco_id`,
	`cefal-rs`.`cefal-rs_associados`.`cefal-rs_contabilidade_id` 				AS `retorno_contabilidade_id`,
	`cefal-rs`.`cefal-rs_associados`.`cefal-rs_associado_data_criacao` 			AS `retorno_data_criacao`,
	`cefal-rs`.`cefal-rs_associados`.`cefal-rs_associado_data_edicao` 			AS `retorno_data_edicao`,
	`cefal-rs`.`cefal-rs_associados`.`cefal-rs_administrador_id` 				AS `retorno_administrador_id`,
	`cefal-rs`.`cefal-rs_associados`.`cefal-rs_associado_status` 				AS `retorno_status`,
	
	
	
	`cefal-rs`.`cefal-rs_categorias`.`cefal-rs_categoria_id` 					AS `retorno_categoria_id`, 
	`cefal-rs`.`cefal-rs_categorias`.`cefal-rs_categoria_nome` 					AS `retorno_categoria`,
	`cefal-rs`.`cefal-rs_categorias`.`cefal-rs_categoria_data_criacao` 			AS `retorno_categoria_data_criacao`,
	`cefal-rs`.`cefal-rs_categorias`.`cefal-rs_categoria_data_edicao` 			AS `retorno_categoria_data_edicao`,
	`cefal-rs`.`cefal-rs_categorias`.`cefal-rs_administrador_id` 				AS `retorno_categoria_administrador_id`,
	`cefal-rs`.`cefal-rs_categorias`.`cefal-rs_categoria_status` 				AS `retorno_categoria_status`,
	
	`cefal-rs`.`cefal-rs_bancos`.`cefal-rs_banco_nome`							AS `retorno_banco`,
	`cefal-rs`.`cefal-rs_bancos`.`cefal-rs_banco_agencia`						AS `retorno_agencia`, 
	`cefal-rs`.`cefal-rs_bancos`.`cefal-rs_banco_conta`							AS `retorno_conta`,

	
	
	`cefal-rs`.`cefal-rs_partidos`.`cefal-rs_partido_id` 						AS `retorno_partido_id`, 
	`cefal-rs`.`cefal-rs_partidos`.`cefal-rs_partido_sigla` 					AS `retorno_coordenadoria`, 
	`cefal-rs`.`cefal-rs_partidos`.`cefal-rs_partido_data_criacao` 				AS `retorno_partido_data_criacao`, 
	`cefal-rs`.`cefal-rs_partidos`.`cefal-rs_partido_data_edicao` 				AS `coordenadoria_partido_edicao`, 
	`cefal-rs`.`cefal-rs_partidos`.`cefal-rs_administrador_id` 					AS `retorno_partido_administrador_id`, 
	`cefal-rs`.`cefal-rs_partidos`.`cefal-rs_partido_status` 					AS `retorno_partido_coordenadoria_status`,
	
	`cefal-rs`.`cefal-rs_coordenadorias`.`cefal-rs_coordenadoria_id` 			AS `retorno_coordenadoria_id`, 
	`cefal-rs`.`cefal-rs_coordenadorias`.`cefal-rs_partido_id` 					AS `retorno_coordenadoria_partido_id`, 
	`cefal-rs`.`cefal-rs_coordenadorias`.`cefal-rs_coordenadoria_data_criacao` 	AS `retorno_coordenadoria_data_criacao`, 
	`cefal-rs`.`cefal-rs_coordenadorias`.`cefal-rs_coordenadoria_data_edicao` 	AS `coordenadoria_data_edicao`, 
	`cefal-rs`.`cefal-rs_coordenadorias`.`cefal-rs_administrador_id` 			AS `retorno_coordenadoria_administrador_id`, 
	`cefal-rs`.`cefal-rs_coordenadorias`.`cefal-rs_coordenadoria_status` 		AS `retorno_coordenadoria_status`,
	
	`cefal-rs`.`cefal-rs_contabilidade`.`cefal-rs_contabilidade_salario` 		AS `retorno_salario_id`, 	
	`cefal-rs`.`cefal-rs_contabilidade`.`cefal-rs_contabilidade_salario` 		AS `retorno_salario`, 
	`cefal-rs`.`cefal-rs_contabilidade`.`cefal-rs_contabilidade_credito` 		AS `retorno_limite_de_credito`,
	`cefal-rs`.`cefal-rs_contabilidade`.`cefal-rs_contabilidade_credito_usado` 	AS `retorno_limite_usado`,	
	(`cefal-rs`.`cefal-rs_contabilidade`.`cefal-rs_contabilidade_credito` - `cefal-rs`.`cefal-rs_contabilidade`.`cefal-rs_contabilidade_credito_usado`)	AS `retorno_limite_atual`,
	
	/*`cefal-rs`.`cefal-rs_setores`.`cefal-rs_setor_id` 							AS `retorno_setor_id`, Está sendo selecionado junto com o associado.*/
	`cefal-rs`.`cefal-rs_setores`.`cefal-rs_setor_nome` 						AS `retorno_setor`, 
	`cefal-rs`.`cefal-rs_setores`.`cefal-rs_setor_data_criacao` 					AS `retorno_setor_data_criacao`, 
	`cefal-rs`.`cefal-rs_setores`.`cefal-rs_setor_data_edicao` 					AS `retorno_setor_data_edicao`, 
	`cefal-rs`.`cefal-rs_setores`.`cefal-rs_administrador_id` 					AS `retorno_setor_adminstrador_id`, 
	`cefal-rs`.`cefal-rs_setores`.`cefal-rs_setor_status` 						AS `retorno_setor_status`,

	`cefal-rs`.`cefal-rs_enderecos`.`cefal-rs_endereco_id` 						AS `retorno_endereco_id`, 
	`cefal-rs`.`cefal-rs_municipios`.`cefal-rs_municipio_id`					AS `retorno_municipio_id`,
	concat_ws(' - ', `cefal-rs`.`cefal-rs_enderecos`.`cefal-rs_endereco_logradouro` ,  `cefal-rs`.`cefal-rs_enderecos`.`cefal-rs_endereco_bairro`, `cefal-rs_municipios`.`cefal-rs_municipio`)	AS `retorno_endereco`, 
	`cefal-rs`.`cefal-rs_enderecos`.`cefal-rs_endereco_data_criacao` 			AS `retorno_endereco_data_criacao`, 
	`cefal-rs`.`cefal-rs_enderecos`.`cefal-rs_endereco_cep` 			AS `retorno_cep`, 
	`cefal-rs`.`cefal-rs_enderecos`.`cefal-rs_endereco_data_edicao` 				AS `retorno_endereco_data_edicao`, 
	`cefal-rs`.`cefal-rs_enderecos`.`cefal-rs_administrador_id` 					AS `retorno_endereco_administrador_id`, 
	`cefal-rs`.`cefal-rs_enderecos`.`cefal-rs_endereco_status` 					AS `retorno_endereco_status`,
	
	`cefal-rs`.`cefal-rs_gabinetes`.`cefal-rs_gabinete_nome` 						AS `retorno_gabinete`, 
	`cefal-rs`.`cefal-rs_gabinetes`.`cefal-rs_gabinete_data_criacao` 					AS `retorno_gabinete_data_criacao`, 
	`cefal-rs`.`cefal-rs_gabinetes`.`cefal-rs_gabinete_data_edicao` 					AS `retorno_gabinete_data_edicao`, 
	`cefal-rs`.`cefal-rs_gabinetes`.`cefal-rs_gabinete_id` 							AS `retorno_gabinete_adminstrador_id`, 
	`cefal-rs`.`cefal-rs_gabinetes`.`cefal-rs_gabinete_status` 						AS `retorno_gabinete_status`,
	
	`cefal-rs`.`cefal-rs_telefones`.`cefal-rs_telefone` 								AS `retorno_telefones`, 
	`cefal-rs`.`cefal-rs_telefones`.`cefal-rs_telefone_data_criacao` 					AS `retorno_telefone_data_criacao`, 
	`cefal-rs`.`cefal-rs_telefones`.`cefal-rs_telefone_data_edicao` 					AS `retorno_telefone_data_edicao`, 
	`cefal-rs`.`cefal-rs_telefones`.`cefal-rs_telefone_id` 							AS `retorno_telefone_adminstrador_id`, 
	`cefal-rs`.`cefal-rs_telefones`.`cefal-rs_telefone_status` 						AS `retorno_telefone_status`	,
	
	`cefal-rs`.`cefal-rs_emails`.`cefal-rs_email` 								AS `retorno_emails`, 
	`cefal-rs`.`cefal-rs_emails`.`cefal-rs_email_data_criacao` 					AS `retorno_email_data_criacao`, 
	`cefal-rs`.`cefal-rs_emails`.`cefal-rs_email_data_edicao` 					AS `retorno_email_data_edicao`, 
	`cefal-rs`.`cefal-rs_emails`.`cefal-rs_email_id` 							AS `retorno_email_adminstrador_id`, 
	`cefal-rs`.`cefal-rs_emails`.`cefal-rs_email_status` 						AS `retorno_email_status`	,
		
	`cefal-rs`.`cefal-rs_dependentes`.`cefal-rs_dependente_id`					AS `retorno_dependente_id`, 
	`cefal-rs`.`cefal-rs_dependentes`.`cefal-rs_dependente_nome` 					AS `retorno_dependente_nome`, 
	`cefal-rs`.`cefal-rs_dependentes`.`cefal-rs_dependente_data_nascimento`			AS `retorno_dependente_data_nascimento`, 
	`cefal-rs`.`cefal-rs_dependentes`.`cefal-rs_dependente_data_criacao` 				AS `retorno_dependente_data_criacao`, 
	`cefal-rs`.`cefal-rs_dependentes`.`cefal-rs_dependente_data_edicao` 				AS `retorno_dependente_data_edicao`, 
	`cefal-rs`.`cefal-rs_dependentes`.`cefal-rs_dependente_id` 						AS `retorno_dependente_adminstrador_id`, 
	`cefal-rs`.`cefal-rs_dependentes`.`cefal-rs_dependente_status` 					AS `retorno_dependente_status`		
	
FROM `cefal-rs`.`cefal-rs_associados`

LEFT JOIN `cefal-rs`.`cefal-rs_coordenadorias` ON (
	`cefal-rs`.`cefal-rs_associados`.`cefal-rs_coordenadoria_id`  = `cefal-rs`.`cefal-rs_coordenadorias`.`cefal-rs_coordenadoria_id` AND
	`cefal-rs`.`cefal-rs_coordenadorias`.`cefal-rs_coordenadoria_status` = 1
)

LEFT JOIN `cefal-rs`.`cefal-rs_partidos` ON (
	`cefal-rs`.`cefal-rs_partidos`.`cefal-rs_partido_id`  = `cefal-rs`.`cefal-rs_associados`.`cefal-rs_coordenadoria_id` AND
	`cefal-rs`.`cefal-rs_partidos`.`cefal-rs_partido_status` = 1
)

LEFT JOIN `cefal-rs`.`cefal-rs_setores` ON (
	`cefal-rs`.`cefal-rs_setores`.`cefal-rs_setor_id`  = `cefal-rs`.`cefal-rs_associados`.`cefal-rs_setor_id` AND
	`cefal-rs`.`cefal-rs_setores`.`cefal-rs_setor_status` = 1
)

LEFT JOIN `cefal-rs`.`cefal-rs_categorias` ON (
	`cefal-rs`.`cefal-rs_categorias`.`cefal-rs_categoria_id`  = `cefal-rs`.`cefal-rs_associados`.`cefal-rs_categoria_id` AND
	`cefal-rs`.`cefal-rs_categorias`.`cefal-rs_categoria_status` = 1
)	

LEFT JOIN `cefal-rs`.`cefal-rs_contabilidade` ON (
	`cefal-rs`.`cefal-rs_contabilidade`.`cefal-rs_associado_id`  = `cefal-rs`.`cefal-rs_associados`.`cefal-rs_associado_id` AND
	`cefal-rs`.`cefal-rs_categorias`.`cefal-rs_categoria_status` = 1
)

LEFT JOIN `cefal-rs_enderecos` ON (
	`cefal-rs_enderecos`.`cefal-rs_associado_id`  = `cefal-rs_associados` .`cefal-rs_associado_id` AND
	`cefal-rs_endereco_status` = 1
)

LEFT OUTER JOIN `cefal-rs_municipios` ON (
	`cefal-rs_enderecos`.`cefal-rs_municipio_id` = `cefal-rs_municipios`.`cefal-rs_municipio_id` AND
	`cefal-rs_municipio_status` = 1
)

LEFT JOIN `cefal-rs_gabinetes` ON (
	`cefal-rs_gabinetes`.`cefal-rs_gabinete_id`  = `cefal-rs_associados` .`cefal-rs_gabinete_id` AND
	`cefal-rs_gabinete_status` = 1
)

LEFT JOIN `cefal-rs_telefones` ON (
	`cefal-rs_telefones`.`cefal-rs_tabela`  = 'cefal-rs_associados' AND
	`cefal-rs_telefones`.`cefal-rs_tabela_id`  = `cefal-rs_associados`.`cefal-rs_associado_id` AND
	`cefal-rs_telefone_status` = 1
)

LEFT JOIN `cefal-rs_emails` ON (
	`cefal-rs_emails`.`cefal-rs_tabela`  = 'cefal-rs_associados' AND
	`cefal-rs_emails`.`cefal-rs_tabela_id`  = `cefal-rs_associados`.`cefal-rs_associado_id` AND
	`cefal-rs_email_status` = 1
)

LEFT JOIN `cefal-rs_dependentes` ON (
	`cefal-rs_dependentes`.`cefal-rs_associado_id`  = `cefal-rs_associados`.`cefal-rs_associado_id` AND
	`cefal-rs_dependente_status` = 1
)

LEFT JOIN `cefal-rs_bancos` ON (
	`cefal-rs_bancos`.`cefal-rs_associado_id` = `cefal-rs_associados`.`cefal-rs_associado_id` AND
	`cefal-rs_bancos`.`cefal-rs_banco_status` = 1
)


WHERE (`cefal-rs`.`cefal-rs_associados`.`cefal-rs_associado_status` = 1)

;
