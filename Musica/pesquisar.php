<!DOCTYPE html>
<meta charset="UTF-8">
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<?php
$conexao = mysqli_connect('localhost', 'root', '', 'plataformamusicas') or die
    ("Sem conexão com o servidor");
/* esse bloco de código em php verifica se existe a sessão, pois o usuário pode
 simplesmente não fazer o login e digitar na barra de endereço do seu navegador
o caminho para a página principal do site (sistema), burlando assim a obrigação de
fazer um login, com isso se ele não estiver feito o login não será criado a session,
então ao verificar que a session não existe a página redireciona o mesmo
 para a index.php.*/
session_start();
if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true))
{
  unset($_SESSION['login']);
  unset($_SESSION['senha']);
  header('location:index.php');
  }

$logado = $_SESSION['login'];



$pesquisa = '';
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pesquisar</title>
</head>

<body>
<table  width="100%" height="969" border="1">
    <tr>
        <td height="15%" colspan="2" style="text-align:center" bgcolor="#2586B0">
         <h1>Plataforma de músicas</h1>
            <br>
        <?php
           echo " Bem vindo $logado";
        ?>
        <div style="text-align:right">    
        <a href="logout.php" 
        style="
        background-color: #AAD5E9;
        color: black;
        padding: 14px 25px;
        text-align: center;
        text-decoration: none;
        display: inline-block;">Logout</a>
    </div>
        </td>
    </tr>
    <tr>
        <td width="10%" height="70%" bgcolor="#AAD5E9 ">
        <p><a href="site.php">Início</a></p>
        <p><a href="playlist.php">Playlist</a></p>
        <p><a href="pesquisar.php">Pesquisar</a></p>
        <p><a href="inserir.php">Inserir (admin)</a></p>

        </td>
    <td bgcolor="#C1DCE8">
    <h2>Pesquisar músicas</h2>

    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    <input type="text" name="pesquisa"  size="22"  value="<?php echo $pesquisa;?>">
    <input type="submit" name="submit"  value="Pesquisar">  
    <br>
    <?php
    $preenchido = true;
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
      if (empty($_POST["pesquisa"])) {
        $Err = "Digite algo para pesquisar.";
        $preenchido = false;
      } else {
          $pesquisa = test_input($_POST["pesquisa"]);
          // check if only contains letters, whitespace and numbers
          if (!preg_match("/^[a-zA-Z-' ]*$/",$pesquisa) && !preg_match("/^[0-9]*$/",$pesquisa)) {
              $Err = "Só é permitido letras e espaços.";
              $preenchido = false;    // pra não cadastrar no banco de dados se o formulario nao tiver completo
          }
      }
        if ($preenchido == true){
          #$consulta = "SELECT codigo, nomemusica, nomeautor, duracao, ano FROM musica";
          $consulta = "SELECT * FROM musica WHERE 
                      codigo LIKE '%{$pesquisa}%' OR
                      nomeMusica LIKE '%{$pesquisa}%' OR
                      nomeAutor LIKE '%{$pesquisa}%' OR
                      genero LIKE '%{$pesquisa}%' OR
                      ano LIKE '%{$pesquisa}%' 
                      ";
          $resultado = mysqli_query ($conexao,$consulta);
          echo "codigo - nome da musica - nome do autor - duracao - ano <br>";
          while ($linha = mysqli_fetch_row($resultado))
          {
          echo $linha[0]." - ".$linha[1]." - ".$linha[2]." - ".$linha[3]." - ".$linha[4]." - ".$linha[5]." - ";?>
          <html>
          <body>
          <audio controls>
          <source src="<?php echo $linha[6]; ?>" type="audio/mpeg"></source>
          
          </audio>
          </body>
          </hmtl>
          <?php
          echo "<br><br>";
          }
          echo "<br><br>";
        }
    
    }
    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    ?>

  
</form>

</td>

  </tr>
  <tr>
    <td colspan="2" bgcolor="#2586B0"> </td>
  </tr>
</table>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>