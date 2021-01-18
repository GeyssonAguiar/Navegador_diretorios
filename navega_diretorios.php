<?php 
session_start();
    

    if(!empty($_REQUEST['action']) && $_REQUEST['action'] == 'raiz')  {

        $diretorio = $_POST['diretorio'];
        // Procura barra e retira de $diretorio 
        $procura_barra = substr($diretorio, (strlen($diretorio) - 1), strlen($diretorio));
        if($procura_barra == '\\') {
            $pos_barra = strrpos($diretorio, '\\');
            $diretorio = substr($diretorio, 0, $pos_barra);
        }
        
        // Cria lista de diretorios de endereço
        $sub_diretorios = scandir($diretorio);
        $_SESSION['diretorio'] = $diretorio;
    }   

    if(!empty($_REQUEST['action']) && $_REQUEST['action'] == 'novo') {
        $temporario = $_POST['diretorio_escolhido'];
        $diretorio = $_SESSION['diretorio'];
        $procura_barra = substr($diretorio, (strlen($diretorio) - 1), strlen($diretorio));
        
        // Procura barra e coloca para junção diretorio + subdiretorio
        if($procura_barra <> '\\') {
            $diretorio = $_SESSION['diretorio'] . '\\' . $temporario;
        }
        
        $_SESSION['diretorio'] = $diretorio;
        $sub_diretorios = scandir($diretorio);
        
    }

    if(!empty($_REQUEST['action']) && $_REQUEST['action'] == 'voltar') {
        $diretorio = $_SESSION['diretorio'];
        $pos_barra = strrpos($diretorio, '\\');
        $volta_diretorio = substr($diretorio, 0, $pos_barra);
        $_SESSION['diretorio'] = $volta_diretorio;
        $diretorio = $volta_diretorio;
        $sub_diretorios = scandir($volta_diretorio);
    }
    $conjunto = '';
    // Recebe form_mostra e substitui o valor de {diretorio}
    
     if(!empty($diretorio)) {
        
        $exclui = array_search('.', $sub_diretorios);
        $exclui2 =  array_search('..', $sub_diretorios);
        
        unset($sub_diretorios[$exclui]);
        unset($sub_diretorios[$exclui2]); 
    }
        foreach($sub_diretorios as $sub_diretorio) {
            $form_option = file_get_contents('html/option.html');
            
            $form_option = str_replace('{diretorio_nome}', $sub_diretorio, $form_option);
            
            $conjunto .= $form_option;
        }
        $form_mostra = file_get_contents('html/form_mostra.html');
        $form_mostra = str_replace('{diretorio}', $diretorio, $form_mostra); 
        $form_mostra = str_replace('{options}', $conjunto, $form_mostra);   
        print($form_mostra);    
    

