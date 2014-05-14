-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2014 at 09:45 AM
-- Server version: 5.1.54
-- PHP Version: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `alp`
--

-- --------------------------------------------------------

--
-- Table structure for table `categoria`
--

CREATE TABLE IF NOT EXISTS `categoria` (
  `idCategoria` int(11) NOT NULL AUTO_INCREMENT,
  `descCategoria` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `nomeArquivo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fotoGaleria` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `perfilCategoria` int(11) NOT NULL,
  PRIMARY KEY (`idCategoria`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=42 ;

--
-- Dumping data for table `categoria`
--

INSERT INTO `categoria` (`idCategoria`, `descCategoria`, `nomeArquivo`, `fotoGaleria`, `perfilCategoria`) VALUES
(2, 'Categoria 01', '6e208c274d8463d464f851ba5c757ea2.jpg', '/borboleta rosa.jpg', 0),
(38, 'Categoria 03', '3760ccf06a6c6240023fb5f35ac9761a.jpg', '/apple-jobs.jpg', 0),
(39, 'Categoria 02', '52eb9cb451c4db763c5122f710725885.jpg', '/viplast.jpg', 0),
(41, 'Divisorias', 'e11d50b0f71276cc628b2451f6b7a0d8.jpg', '/DIVISORIAS.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contato`
--

CREATE TABLE IF NOT EXISTS `contato` (
  `idContato` int(11) NOT NULL AUTO_INCREMENT,
  `endContato` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `cidadeContato` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `telefone1Contato` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `telefone2Contato` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `telefone3Contato` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `emailContato` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `mapaContato` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idContato`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `contato`
--

INSERT INTO `contato` (`idContato`, `endContato`, `cidadeContato`, `telefone1Contato`, `telefone2Contato`, `telefone3Contato`, `emailContato`, `mapaContato`) VALUES
(1, 'CNB 03, LOTE 01, SALA 309', 'Brasília - DF', '(61) 3024-1336', '(61) 3024-1336', '', 'alp@alp.com.br', '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d491459.88085384585!2d-47.79764365!3d-15.775966799999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1spt-BR!2sbr!4v1398292822906" width="100%" height="250" frameborder="0" style="border:0"></iframe>');

-- --------------------------------------------------------

--
-- Table structure for table `dica`
--

CREATE TABLE IF NOT EXISTS `dica` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` text COLLATE utf8_unicode_ci NOT NULL,
  `nomeArquivo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fotoGaleria` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `dica`
--


-- --------------------------------------------------------

--
-- Table structure for table `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
  `idEmpresa` int(11) NOT NULL AUTO_INCREMENT,
  `descEmpresa` text COLLATE utf8_unicode_ci NOT NULL,
  `nomeArquivo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fotoGaleria` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idEmpresa`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `empresa`
--

INSERT INTO `empresa` (`idEmpresa`, `descEmpresa`, `nomeArquivo`, `fotoGaleria`) VALUES
(1, '<h1 style="text-align: left;">Sobre a ALP Forros e Divis&oacute;rias</h1>\r\n<p>&nbsp;<img src="http://criattus.com.br/site/images/logo.png" alt="" width="179" height="176" /></p>\r\n<p>A Colombo Motores El&eacute;tricos j&aacute; atua no mercado h&aacute; mais de 30 anos. Toda a equipe est&aacute; envolvida na perspectiva de alcan&ccedil;ar os objetivos tra&ccedil;ados pela empresa - Satisfa&ccedil;&atilde;o de nosso cliente. A empresa foi fundada na d&eacute;cada de 80, juntamente com a hurbaniza&ccedil;&atilde;o do setor H norte. A colombo vem ao longo desse tempo, buscando um aprimoramento em todos os aspectos. Hoje, sob nova administra&ccedil;&atilde;o, sempre se comprometendo, com voc&ecirc; cliente/parceiro/amigo em oferecer um ambiente agrad&aacute;vel, um atendimento diferenciado e uma m&atilde;o de obra com qualidade. Nunca esquecendo o nosso principal objetivo - atender as necessidades de nosso cliente, com responsabilidade, prestatividade e principalmente com honestidade.</p>\r\n<h4>Motivos de orgulho</h4>\r\n<p>Sempre trabalhando com honestidade e respeito com o cliente/parceiro/amigo</p>\r\n<h3>Um pouco da nossa hist&oacute;ria</h3>\r\n<p>Sabemos que o motor el&eacute;trico tornou-se um dos mais not&oacute;rios inventos do homem ao longo de seu desenvolvimento tecnol&oacute;gico. M&aacute;quina de constru&ccedil;&atilde;o simples, custo reduzido vers&aacute;til e n&atilde;o poluente, seus princ&iacute;pios de funcionamento, constru&ccedil;&atilde;o e sele&ccedil;&atilde;o necessitam ser conhecidos para que ele desempenhe seu papel relevante no mundo de hoje e a&nbsp;<strong>COLOMBO</strong>, oferece confian&ccedil;a no trabalho executado, apego &agrave;s normas t&eacute;cnicas e a qualidade das pe&ccedil;as utilizadas na montagem dos motores. Com isso transmite a confian&ccedil;a necess&aacute;ria, permitindo oferecer a nossos clientes o certificado de garantia personalizado.</p>\r\n<p>A empresa se coloca a inteira disposi&ccedil;&atilde;o para solucionar seus problemas no segmento de motores el&eacute;tricos, bombas, ferramentas el&eacute;tricas, cortadores de grama e grupo geradores.</p>\r\n<p>Visite-nos e conhe&ccedil;a os nossos pre&ccedil;os e condi&ccedil;&otilde;es de pagamento.</p>\r\n<p>Nos sentiremos lisongeados em t&ecirc;-lo como nosso cliente/parceiro.</p>', '346d1735c2e084544aea8d960bfed97e.jpg', '/service1open.jpg'),
(2, '<h1>DICAS</h1>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>Texto com dicas.</p>', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `imagem`
--

CREATE TABLE IF NOT EXISTS `imagem` (
  `idImagem` int(11) NOT NULL AUTO_INCREMENT,
  `fotoGaleria` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nomeArquivo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idImagem`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `imagem`
--

INSERT INTO `imagem` (`idImagem`, `fotoGaleria`, `nomeArquivo`) VALUES
(4, '/parceiro_bsb-motos.png', '87696e27070a3ba5f14192815a61a849.png');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `idLogin` int(11) NOT NULL AUTO_INCREMENT,
  `nomeLogin` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `responsavelLogin` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `telefoneLogin` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `usuarioLogin` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `senhaLogin` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `perfilLogin` int(11) NOT NULL,
  PRIMARY KEY (`idLogin`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`idLogin`, `nomeLogin`, `responsavelLogin`, `telefoneLogin`, `usuarioLogin`, `senhaLogin`, `perfilLogin`) VALUES
(1, 'ALP Forros e Divisórias', 'Anderson Leonidas', '(61) 3024-1336', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 0);

-- --------------------------------------------------------

--
-- Table structure for table `parceiro`
--

CREATE TABLE IF NOT EXISTS `parceiro` (
  `idParceiro` int(11) NOT NULL AUTO_INCREMENT,
  `nomeArquivo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fotoGaleria` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idParceiro`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `parceiro`
--

INSERT INTO `parceiro` (`idParceiro`, `nomeArquivo`, `fotoGaleria`) VALUES
(7, 'bde48a01fa2eefada489f951cf9bd004.jpg', '/divitec.jpg'),
(8, '97cc71d4a28cb5d81a1b97f4e3e26302.jpg', '/plastasso.jpg'),
(9, 'd0611e813ae0a0a2404cab4f67b57270.jpg', '/transgesso.jpg'),
(10, '5a9bbd151a573bd9c34339003502ed66.jpg', '/viplast.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `principal`
--

CREATE TABLE IF NOT EXISTS `principal` (
  `idPrincipal` int(11) NOT NULL AUTO_INCREMENT,
  `tituloPrincipal` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descPrincipal` text COLLATE utf8_unicode_ci NOT NULL,
  `nomeArquivo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fotoGaleria` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `linkPrincipal` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `linkExterno` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idPrincipal`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `principal`
--

INSERT INTO `principal` (`idPrincipal`, `tituloPrincipal`, `descPrincipal`, `nomeArquivo`, `fotoGaleria`, `linkPrincipal`, `linkExterno`) VALUES
(1, 'Nossos serviços', 'Locação de carros, vans, microonibus e ônibus', '1a31dd0138a6cc73d1675e70e68ab61b.png', '/4fcd32dc193b4b6b3c539aabcafaaeb7.png', '', ''),
(3, 'Pacotes', 'Confira os melhores pacotes terrestres e aéreos', 'd30aa65bf71355a10a248f774bc86669.png', '/service3.png', '', ''),
(8, '', 'Saiba tudo sobre esse pacote a viagem e os detalhes', '', '', '18', ''),
(4, 'Nossos Serviços', 'Conheça nossos serviços e diferenciais', '', '', '', ''),
(18, 'Serviço 04', 'Serviço 04', '', '', '17', ''),
(5, 'DRYWALL', '', 'f7ad8ed3fff89143ce6a2c21c0a44d52.jpg', '/drywall.jpg', 'produtos', ''),
(6, 'FORROS PVC', '', '50ba57b561cb0669b9bfb2d6f47226ec.jpg', '/PVC.jpg', 'produtos', ''),
(7, 'DIVISORIAS', '', '3236f5c621b97e7fe7d1bd4b2fd84363.jpg', '/DIVISORIAS.jpg', 'produtos', ''),
(2, 'Nossos Pacotes', 'Confira os pacotes que preparamos para você', '2f2f888c9e5bedf38890a3bcd9581b6c.png', '/service2.png', '', ''),
(17, 'Serviço 03', 'Serviço 03', '', '', '18', 'http://www.criattus.com.br'),
(16, 'Serviço 02', 'Serviço 02', '', '', '17', 'http://www.criattus.com.br'),
(15, '', '', 'd18afa4952a6192297402f580fa9af82.png', '/CARTAO DE CREDITO.png', '', ''),
(9, 'Nossas Viagens Nacionais', 'Roteiro com nossas viagens e seguros de viagens', '', '', '', ''),
(10, '', '', 'c449827de198eb15c191b45a6ad153be.jpg', '/agende.jpg', 'contato', ''),
(11, '', '', '16889b05d738c4489e5e9281695fe718.jpg', '/ORÇAMENTO.jpg', 'contato', ''),
(12, '', '', 'b18ef9c80ff233a6efaecbd5ed7a0f86.jpg', '/PORTFOLIO.jpg', 'portfolio', ''),
(13, 'Roteiro 04', 'Roteiro 04', '', '', '17', ''),
(14, 'Nossos Serviços', 'Conheça nossos serviços', '', '', '', ''),
(19, 'Breve descrição sobre a Empresa', '<p>Disponibilizamos as melhores op&ccedil;&otilde;es de viagens terrestres e a&eacute;reas, servi&ccedil;os de seguro de viagem e fretamento de &ocirc;nibus.</p>\r\n<p>Entre em contato conosco e saiba tudo sobre nossos pacotes e servi&ccedil;os.</p>\r\n<p>Venha e confira. Fa&ccedil;a-nos uma visita.</p>', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `produto`
--

CREATE TABLE IF NOT EXISTS `produto` (
  `idProduto` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_idCategoria` int(11) NOT NULL,
  `tituloProduto` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descProduto` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nomeArquivo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `fotoGaleria` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `perfilProduto` int(11) NOT NULL,
  PRIMARY KEY (`idProduto`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `produto`
--

INSERT INTO `produto` (`idProduto`, `categoria_idCategoria`, `tituloProduto`, `descProduto`, `nomeArquivo`, `fotoGaleria`, `perfilProduto`) VALUES
(1, 4, 'Nome do produto', '', 'cf5f8e7ad295913bacb19e3d2e79f38d.jpg', '/04.jpg', 0),
(2, 4, 'Nome do produto', '', '6952226739204c69d3aa540509b86175.jpg', '/03.jpg', 0),
(3, 4, 'Nome do produto', '', '0e0367a2498448f5d7b9059fbdef94f9.jpg', '/02.jpg', 0),
(4, 3, 'Nome do produto', '', '77bb024e410fa2f6d87c646a774d89a7.jpg', '/front_2.jpg', 0),
(5, 2, 'Nome do produto', '<p>Descri&ccedil;&atilde;o</p>', '327cdfd384eab06356aafa118b6fac71.jpg', '/02.jpg', 0),
(6, 4, 'Nome do produto', '', 'f72674792746f248d24880d73760fafd.jpg', '/01.jpg', 0),
(10, 5, 'Nome do produto', '', '67821fca45dc89da08b778c0fa2650ea.jpg', '/04.jpg', 0),
(11, 5, 'Nome do produto', '', '68856678acb63ef723bd29a1bad8584f.jpg', '/03.jpg', 0),
(12, 5, 'Nome do produto', '<p>teste</p>', '22d17c629946442bd114b48504445611.jpg', '/02.jpg', 0),
(13, 2, 'Nome do produto', '', 'ba5c9045cfafad259f3c5d65f0f7a6bb.jpg', '/01.jpg', 0),
(14, 5, 'Nome do produto', '<p>Descri&ccedil;&atilde;o do produto.</p>', '87301486317a0727c23048927265fa24.jpg', '/01.jpg', 0),
(15, 2, 'Nome do produto', '', 'fa3cf253bd579261d0285d61f0963eb5.jpg', '/03.jpg', 0),
(16, 2, 'Nome do produto', '', '3531e27f8fb810a3ff4e99bbe002d3e5.jpg', '/04.jpg', 0),
(17, 2, 'Nome do produto', '', '6c473a114d7f6e896b16cf868397adf8.jpg', '/11.jpg', 0),
(18, 2, 'Nome do produto', '', '5970308b4363b40a9be179232093fe59.jpg', '/11.jpg', 0),
(19, 2, 'Nome do produto', '', 'e94dfd9ecc8321b758601545a2283e16.jpg', '/09.jpg', 0),
(25, 2, 'Drywall', NULL, 'c52b9db660bc29a1607a948d366d3460.jpg', '/drywall.jpg', 0),
(27, 0, 'Divisorias', NULL, '8263006fb6a75f2f4486ed0cd8d1f6ee.jpg', '/DIVISORIAS.jpg', 0),
(26, 41, 'Diversos', NULL, '935917d5bea4bcaa730aebe51f739483.jpg', '/SLIDER2.jpg', 1),
(28, 41, 'divisorias', NULL, 'fa72ac069b5b2242a5c8458af0f2f246.jpg', '/SLIDER3.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `servico`
--

CREATE TABLE IF NOT EXISTS `servico` (
  `idServico` int(11) NOT NULL AUTO_INCREMENT,
  `tituloServico` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `descServico` text COLLATE utf8_unicode_ci NOT NULL,
  `nomeArquivo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fotoGaleria` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `categoria_idServicoCategoria` int(11) NOT NULL,
  PRIMARY KEY (`idServico`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=21 ;

--
-- Dumping data for table `servico`
--

INSERT INTO `servico` (`idServico`, `tituloServico`, `descServico`, `nomeArquivo`, `fotoGaleria`, `categoria_idServicoCategoria`) VALUES
(19, 'Serviço _02', '<p>Servico 2</p>', '7a44d12f7eaa30206f30b22c167059d5.png', '/logomarca (1).png', 1),
(20, 'Serviço _03', '<p>asdfasdfasdfasdf</p>', 'cbd10f72d09aba46ad2a306aab60729a.png', '/logomarca (1).png', 1),
(16, 'Serviço _01', '<p>Servi&ccedil;o teste.</p>', '99e1a7227e15db9d111eabe22fef1ba6.png', '/parceiro_bsb-motos.png', 1),
(17, 'Servico _02', '', 'e2b35425e3b2d9ecaa0bc5cb786ba980.png', '/dose_dupla_heineken.png', 2),
(18, 'Serviço _03', '', '552bd83a92d05ef872a542c19f1079ee.png', '/parceiro_bsb-motos.png', 2);

-- --------------------------------------------------------

--
-- Table structure for table `servico_categoria`
--

CREATE TABLE IF NOT EXISTS `servico_categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoriaServico` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `servico_categoria`
--

INSERT INTO `servico_categoria` (`id`, `categoriaServico`) VALUES
(1, 'Viagens Nacionais'),
(2, 'Viagens Internacionais');

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE IF NOT EXISTS `slider` (
  `idSlider` int(11) NOT NULL AUTO_INCREMENT,
  `nomeArquivo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fotoGaleria` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tituloSlider` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `descSlider` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idSlider`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`idSlider`, `nomeArquivo`, `fotoGaleria`, `tituloSlider`, `descSlider`) VALUES
(18, '14c04d842ddb8dbed2e5aac6da77ee93.jpg', '/slide1.jpg', '', ''),
(19, 'dbc7a8fc1bc093c6474e451a4dabaa46.jpg', '/slide2.jpg', 'Título slider', 'Texto slider');
