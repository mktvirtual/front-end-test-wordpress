<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'wordpress');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'root');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', '123456');

/** Nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Charset do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '~_(.tHD)l451O~i_>&Fb,b`h3dNO3ENL=N;42.v`UCU@>z*UM_;KMdl}~}pUD*A:');
define('SECURE_AUTH_KEY',  '6}1g;lS#,%6}f*On4AA((-/a%w87EX?]kz1p0{:P;a$IAx r9B2$)K7deu@lS6l9');
define('LOGGED_IN_KEY',    '&W3Bq)H!vK)>N^A=x,k(1He$5Yv3@Ts<|ryA#fQ$K-fL?!^xMGg?8; T?:C=8G0E');
define('NONCE_KEY',        ';v BB1-g@(r[Y~m<gr<j6jEsz`PHU3c>*xIb@.]4$(8kDnMRlO7?h26MQdd&.7hd');
define('AUTH_SALT',        'xAwGEWJ{3~r_e3IKa&vx1k<[e0]f@A4Sv#iSzZRLBJ}i.+#fyW 0#p(^4|93WP.&');
define('SECURE_AUTH_SALT', 'kknwfKHi]RMov;(@S6L?,:teuntG.jyMMv.ilEZW0%?.XU;f$WnF!aP8;]0ItnXd');
define('LOGGED_IN_SALT',   'V,BoU&H0!ySf2mZoc0/t!gjt]f2,:&ujOk4lCHMlw%A&2L=OaUh6b/=rPDzV#VXm');
define('NONCE_SALT',       'g;eu7_cCTY)uv7Jm#Pfi=,6,@LE?O:$#<uu)~yy$(b#fXU}%73@8#:^Tm=}HOj6[');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
