<?php

	//if(basename(__FILE__) == basename($_SERVER[PHP_SELF])){header('Location: 404.html');}else{
		
		//Converte e valida data.
		function validaData($data){
			$aux = explode ('/', $data);
			if(	
				($aux[1] < 1)	|| ($aux[1] > 12) || 
				($aux[0] < 1) 	|| ($aux[0] > 31) || 
				($aux[2] < 2013)|| ($aux[0] > 2020)
			){
				return false;
			}else{
				$data = $aux[2].'-'.$aux[1].'-'.$aux[0];
				return($data);
			}
		}

		//Converte e valida hora.
		function validaHora($hora){
			$aux = explode (':', $hora);
			if(
				($aux[0] < 0) 	|| 
				($aux[0] > 24) 	|| 
				($aux[0] == '')	||
				
				($aux[1] < 0) 	|| 
				($aux[1] > 59)	||
				($aux[1] == '')
			){				
				return false;			
			}else{
				$hora = $aux[0].':'.$aux[1];
				return($hora);
			}
		}
		
		//Somente valida se data e hora são maiores que agora.
		function validaDataeHora($data,$hora){
			$data = explode('-', $data);
			$hora = explode(':', $hora);
			
			$agoraData = date('Y-m-d');
			$agoraData = explode('-', $agoraData);
			
			$agoraHora = date('H:i');
			//resposta(array("$agoraHora"));
			$agoraHora = explode(':', $agoraHora);

			if(	
				($data[0] < $agoraData[0])	||
			
				($data[0] == $agoraData[0])	&&
				($data[1] < $agoraData[1])	||

				($data[0] == $agoraData[0])	&&
				($data[1] == $agoraData[1])	&&
				($data[2] < $agoraData[2])	||
				
				($data[0] == $agoraData[0])	&&
				($data[1] == $agoraData[1])	&&
				($data[2] == $agoraData[2])	&&
				($hora[0] < $agoraHora[0])	||
				
				($data[0] == $agoraData[0])	&&
				($data[1] == $agoraData[1])	&&
				($data[2] == $agoraData[2])	&&
				($hora[0] == $agoraHora[0])	&&
				($hora[1] < $agoraHora[1])
			){
				//resposta(array(" 1 - $data[0]' '$agoraData[0]', '$data[1]' '$agoraData[1]', '$data[2]' '$agoraData[2]', '$hora[0]' '$agoraHora[0]', '$hora[1]' '$agoraHora[1]"));
				return false;
			}else{
				//resposta(array(" 2 - $data[0]' '$agoraData[0]', '$data[1]' '$agoraData[1]', '$data[2]' '$agoraData[2]', '$hora[0]' '$agoraHora[0]', '$hora[1]' '$agoraHora[1]"));
				return true;
			}
		}

		function toDeceimal($valor){
			$source = array('.', ',');
			$replace = array('', '.');
			$valor = str_replace($source, $replace, $valor); //remove os pontos e substitui a virgula pelo ponto
			return $valor; //retorna o valor formatado para gravar no banco
		}
		
		function toMoeda($valor){
			$source = array(',', '.');
			$replace = array('.', '');
			$valor = str_replace($source, $replace, $valor); //remove os pontos e substitui a virgula pelo ponto
			return $valor; //retorna o valor formatado para gravar no banco
		}			
		
	//}
?>