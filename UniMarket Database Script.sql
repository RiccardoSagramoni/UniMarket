SET NAMES latin1;
SET FOREIGN_KEY_CHECKS = 0;

BEGIN;
DROP DATABASE IF EXISTS `UniMarketDB`;
CREATE DATABASE `UniMarketDB`;
COMMIT;

USE `UniMarketDB`;

-- --------------------------------------------------------
-- 					TABLE STRUCTURES
-- --------------------------------------------------------
-- ----------------------------
-- Table Structure `User`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `User`(
	`userID` INT UNSIGNED AUTO_INCREMENT NOT NULL,
    `Email` VARCHAR(320) NOT NULL,
    `Password` VARCHAR(64) NOT NULL,
    `Nome` VARCHAR(64) NOT NULL,
    `Cognome` VARCHAR(64) NOT NULL,
    `DataNascita` DATE NOT NULL,
	`Sesso` ENUM('M','F') NOT NULL,
	`Telefono` VARCHAR(11) NOT NULL,
	`Indirizzo` VARCHAR(64) NOT NULL,
	`Citta` VARCHAR(64) NOT NULL,
	`CAP` CHAR(5) NOT NULL,
    `IsAdmin` TINYINT(1) NOT NULL,
	PRIMARY KEY(userID),
    UNIQUE(Email)
);

-- ----------------------------
-- Table Structure `Item`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `Item`(
	`itemID` INT UNSIGNED AUTO_INCREMENT NOT NULL,
    `Nome` VARCHAR(128)  NOT NULL,
    `Categoria` ENUM('alcol', 'bibite', 'carne', 'dolci', 'frutta', 'latte', 'mondobimbo', 'pasta', 'pesce', 'surgelati', 'varie', 'veggie') NOT NULL,
    `Descrizione` VARCHAR(4096) NOT NULL,
	`Origine` VARCHAR(64) NOT NULL,
    `Costo` FLOAT(5,2) UNSIGNED NOT NULL,
	`Disponibilita` INT UNSIGNED NOT NULL,
    PRIMARY KEY(`itemID`)
);

-- ----------------------------
-- Table Structure `ShoppingCart`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `ShoppingCart`(
	`shoppingID` INT UNSIGNED AUTO_INCREMENT NOT NULL,
    `userID` INT UNSIGNED NOT NULL,
    `TimestampApertura` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
    `TimestampChiusura` TIMESTAMP NULL,
	`Costo` FLOAT(7,2) UNSIGNED,
	`Indirizzo` VARCHAR(64),
	`Citta` VARCHAR(64),
	`CAP` CHAR(5),
    PRIMARY KEY(`shoppingID`),
    UNIQUE(`userID`,`TimestampApertura`),
    CONSTRAINT
		FOREIGN KEY(`userID`)
        REFERENCES `User`(`userID`)
		ON UPDATE NO ACTION
		ON DELETE CASCADE
);

-- ----------------------------
-- Table Structure `ItemTaken`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `ItemTaken`(
	`shoppingID` INT UNSIGNED NOT NULL,
    `itemID` INT UNSIGNED NOT NULL,
    `howMany` INT UNSIGNED NOT NULL,
    PRIMARY KEY(shoppingId, itemId),
    CONSTRAINT
		FOREIGN KEY(`shoppingID`)
        REFERENCES `ShoppingCart`(`shoppingID`)
		ON UPDATE NO ACTION
		ON DELETE CASCADE,
	CONSTRAINT
		FOREIGN KEY(`itemID`)
        REFERENCES `Item`(`itemID`)
		ON UPDATE NO ACTION
		ON DELETE NO ACTION
);

-- ----------------------------
-- Table Structure `Recensione`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `Recensione`(
	`Autore` INT UNSIGNED NOT NULL,
    `ProdottoRecensito` INT UNSIGNED NOT NULL,
    `Timestamp` TIMESTAMP NOT NULL,
    `Votazione` TINYINT UNSIGNED NOT NULL,
    `Descrizione` VARCHAR(2048) NOT NULL,
	PRIMARY KEY(`Autore`, `ProdottoRecensito`),
    CONSTRAINT
		FOREIGN KEY(`Autore`)
        REFERENCES `user`(`userID`)
		ON UPDATE NO ACTION
		ON DELETE CASCADE,
	CONSTRAINT
		FOREIGN KEY(`ProdottoRecensito`)
        REFERENCES `Item`(`itemID`)
		ON UPDATE NO ACTION
		ON DELETE CASCADE
);

-- ----------------------------
-- Table Structure `Costanti`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `Costanti`(
	`id` INT UNSIGNED AUTO_INCREMENT NOT NULL,
	`Descrizione` VARCHAR(100) NOT NULL,
	`Valore` FLOAT NOT NULL,
	PRIMARY KEY(`id`)
);

-- --------------------------------------------------------
-- 					RECORDS of TABLES	
-- --------------------------------------------------------
BEGIN;
INSERT INTO `user` VALUES
(NULL,'admin@unimarket.it','admin', 'Admin', 'Admin', '1985-08-02', 'M','3454567890','Via Maroncelli, 1','Viareggio','55049', 1),
(NULL,'pippo@pippo.it','pippo', 'Pippo', 'De Pippis', '1982-05-02', 'M','1234567890','Via De Pippis, 1','Pisa','56121', 0),
(NULL,'mario@gmail.com', 'password', 'Mario', 'Bianchi', '1998-02-10', 'M', '1234567891', 'Via Diotisalvi, 1', 'Pisa', '56121', 0),
(NULL,'carlorossi@gmail.com','password','Carlo','Rossi','1990-03-01','M','33312334565','via Marco Polo, 5','Viareggio','55049',0),
(NULL,'riccardo.sagramoni@gmail.com','password','Riccardo','Sagramoni','1998-02-10','M','33365434565','via Fratti, 15','Viareggio','55049',1)
;
COMMIT;
BEGIN;
INSERT INTO `item` VALUES
(1, 'Pomodori San Marzano DOP, 500 gr.', 'frutta', 'Il Pomodoro San Marzano dell’Agro Sarnese-Nocerino DOP presenta una forma allungata, un colore rosso tipico della varietà, una cuticola facilmente staccabile ed una ridotta quantità di semi. Il sapore è tipicamente agrodolce. La zona di produzione del Pomodoro San Marzano dell’Agro Sarnese-Nocerino DOP si estende a molti comuni delle province di Napoli, Salerno ed Avellino.', 'San Marzano sul Sarno (SA), Italia', 0.90, 100),
(2, 'Limoni di Sorrento, 1 kg', 'frutta', 'Il limone è originario dell\’India. Secondo alcuni reperti archeologici, era presente in Italia già nel II secolo dopo Cristo, ma la sua coltivazione ebbe inizio intorno al 1100-1200 ad opera degli Arabi, che lo introdussero nel bacino del Mediterraneo. L\’Italia occupa il primo posto nella produzione mondiale di limoni. La regione maggiormente interessata dalla coltura è la Sicilia, dove si ottiene circa il 90% del raccolto nazionale. Il limone fiorisce in vari periodi dell\’anno, dando luogo a diversi tipi di frutti, tra cui i marzani, i limoni invernali e i bianchetti che derivano dalle fioriture di fine inverno-primavera, i verdelli, prodotti dalla fioritura estiva. La pianta del limone è sensibile alle escursioni termiche ed all\’umidità, per cui le zone più vocate alla coltivazione sono le aree costiere a clima caldo secco, dove questo frutto può rifiorire tutto l\’anno. Il limone è quindi disponibile durante tutto l\’arco dei dodici mesi. Tra le varietà più diffuse in Italia, ricordiamo Femminello, Monachello, Interdonato, Limone di Sorrento.', 'Sorrento (NA), Italia', 1.63, 100),
(3, 'Arance Tarocco, 1 kg', 'frutta', 'Arancia a polpa succosa, profumata, di colore arancio, pigmentata di rosso.', 'Sicilia, Italia', 1.52, 200),
(4, 'Mele Fuji, 1 kg', 'frutta', 'Selezionata nel 1939 nel distretto giapponese di Morioka, la varietà Fuji è oggi ampiamente coltivata in molte zone del mondo grazie alla sua alta produttività ed alle buone caratteristiche gustative. La mela Fuji è caratterizzata dalla dolcezza e dalla succosità della polpa. La buccia ha un colore che può variare dal rosso chiaro al rosso scuro, più o meno uniforme, con colorazione di fondo giallo-verde; la polpa è biancastra e molto zuccherina.', 'Trentino, Italia', 1.75, 30),
(5, 'Ananas, 1.5 kg', 'frutta', 'Frutto esotico e profumato. E\' coltivato in tutta la fascia tropicale e dopo la raccolta arriva via nave o via aerea dalla Costa Rica, Costa d\'Avorio e Ghana. Il frutto è maturo quando la buccia ha colore giallo-arancio ed emana profumo.', 'Costa Rica', 2.55, 40),
(6, 'Zucchine, 900 gr.', 'frutta', 'Appartenente alla famiglia delle Cucurbitacee, lo zucchino è una specie erbacea con ciclo di coltivazione annuale. Per quanto riguarda i terreni, lo zucchino, pur mostrando una discreta adattabilità, preferisce quelli leggermente acidi, ricchi di sostanza organica. Per le colture precoci sono preferibili i terreni sciolti.', 'Italia', 2.35, 50),
(7, 'Cipolle bianche, 1 kg', 'frutta', 'La cipolla è il bulbo commestibile prodotto dall\'omonima pianta erbacea; fortemente aromatica, questa verdura è botanicamente imparentata con altri ortaggi-spezia dalle caratteristiche simili, come aglio, porro, scalogno ed erba cipollina. Immancabile ingrediente di numerose ricette, la cipolla bianca si distingue per l\'abbondante presenza di oligoelementi, vitamine ed enzimi che stimolano la digestione e il metabolismo.', 'Italia', 2.00, 100),
(8, 'Carote, 1kg', 'frutta', 'Carote di varietà "Nantes", di colore arancio vivo. Le carote sono alimenti molto nutrienti, ricchi di vitamina A,B,C,PP e E, capaci di restare edibili a lungo', 'Italia', 1.05,30),
(9, 'Pere Abate, 1kg', 'frutta', 'La pera Abate ha forma allungata, buccia sottile di colore verde-giallo, polpa soda e molto succosa, zuccherina e aromatica. Di grande digeribilità, la pera svolge un\'azione diuretica, rinfrescante e lassativa ed è particolarmente indicata nell\'alimentazione di giovani ed anziani.', 'Toscana, Italia', 2.10,32),
(10, 'Insalata Lattuga, 600 gr.', 'frutta', 'Di origine ancora piuttosto incerta (sembra provenire dalla Siberia), il gruppo delle insalate era già conosciuto e coltivato dai Romani, che, ritenendole piuttosto insipide, preferivano consumarle associandole a foglie aromatizzanti di rucola. Fino al Rinascimento la coltivazione interessò pochissime varietà, che fecero poi registrare un netto incremento a partire dal XVII secolo, in seguito all\'avvento di una nuova tecnica che consentì la coltura forzata di questi vegetali. Pianta a ciclo di coltivazione annuale, appartenente alla famiglia delle Composite, la lattuga presenta un apparato radicale superficiale, con fusto breve e carnoso su cui si inseriscono le foglie. Per quanto riguarda il terreno, questa specie vegetale non ha esigenze particolari e si adatta bene sia ai terreni sabbiosi che a quelli argillosi. La lattuga appartiene alla subspecie capitata, caratterizzata da grumoli rotondeggianti, più o meno compatti e foglie lisce.', 'Italia', 0.80, 20),
(11, 'Filetto a fette di scottona piemontese, 400 grammi', 'carne', 'La scottona è un bovino adulto di sesso femminile di età superiore ai 12 mesi, che non ha mai partorito, allevato per la produzione di carne. La Razza Piemontese è una razza da carne pregiata originaria del Piemonte, i cui animali si caratterizzano per uno sviluppo pronunciato della coscia. La carne si distingue per il fatto che è piuttosto magra e per una tessitura fine che conferisce tenerezza.', 'Piemonte, Italia', 12.50, 20),
(12, 'Spaghetti Barilla n.5 di semola di grano duro, 1 kg', 'pasta', 'Nuovi Spaghetti n.5 Barilla, dal gusto più consistente, capaci di trattenere al meglio i tuoi sughi. <br>Il segreto? Una nuova combinazione di grani duri eccellenti e trafile ridisegnate nei minimi dettagli, con la cura e la passione di chi fa pasta da oltre cent\'anni.', 'Parma (PR), Italia', 0.75, 150),
(13, 'Pan Carré Mulino Bianco, 24 fette 400 gr.', 'pasta', 'Pane di tipo "0" con olio di girasole e destrosio, ideale per tostare, senza strutto e olio di palma', 'Italia', 0.70, 35),
(14, 'Petto di Pollo, 600 gr.', 'carne','Animale giovane, maschio o femmina, selezionato ed allevato per la produzione di carne. L\'età della macellazione varia dai 35 ai 56 giorni, in funzione dei tagli.', 'Italia', 4.63, 15),
(15, 'Salame Citterio, 70 gr.', 'carne', '100% Italiano, Lenta stagionatura naturale, Salame di Milano - Antica ricetta di Giuseppe Citterio dal 1878, Senza glutine, Senza derivati del latte', 'Santo Stefano Ticino (MI), Italia', 1.90, 20),
(16, 'Prosciutto San Daniele, 80 gr.', 'carne', 'Il Prosciutto di San Daniele è ottenuto da cosce selezionate e stagionate nel pieno rispetto del Disciplinare di produzione. Ha un gusto delicato e dolce con aroma fragrante e caratteristico', 'San Daniele del Friuli (UD), Italia', 2.90, 15),
(17, '6 uova grandi fresche, Ovomaremma', 'carne', 'Da allevamento all\'aperto. Le nostre uova provengono da pollai di piccole dimensioni in cui le galline dispongono di ampi spazi all\'aria aperta (almeno 4 mq per capo). La passione per il benessere degli animali, la produzione limitata e il rispetto di rigide norme igieniche in ogni fase della produzione assicurano l\'elevata qualità di queste uova.', 'Italia', 2.10, 50),
(18, 'Tonno all\'olio d\'oliva Rio Mare, 2x160 gr.','pesce','Tonno di qualità "pinne gialle", contiene due scatolette di peso 160 gr ciascuna, 140 gr. sgocciolato','Italia',5.20, 100),
(19,'Ceci Esselunga BIO','varie','Ceci biologici lessati. Peso netto sgocciolato 240 gr.','Italia',0.90,200),
(20, 'Latte Mukki UHT intero, 1 litro', 'latte', 'Latte intero a lunga conservazione', 'Italia', 1.50, 200),
(21, 'Filetto di salmone scozzese affumicato, 100 gr.', 'pesce', 'Sal Seafood seleziona per Voi questo Salmone Affumicato utilizzando solo pesce fresco di qualità Superior proveniente dalle cristalline acque scozzesi al largo delle Isole Shetland. Per ottenere questo gusto unico, i filetti di salmone fresco sono accuratamente rifilati e salati a mano con sale marino secco. Vengono poi affumicati a freddo con legno di quercia purissimo, secondo la ricetta tradizionale tramandatasi di generazione in generazione. Questa busta è stata confezionata con la massima cura ed attenzione artigianale per garantire la massima freschezza al nostro Filetto di Salmone Scozzese Affumicato. Per preservare tutto il suo sapore e per mantenerlo in perfette condizioni, conservate la busta sigillata ad una temperatura tra 0°C e +4°C. Per un miglior risultato togliete il Salmone Affumicato dalla confezione e lasciatelo a temperatura ambiente qualche minuto prima di servirlo. Buon Appetito!', 'Scozia', 6.65, 30),
(22, 'Filetto di trota salmonata, 2 pezzi, 400 gr.', 'pesce', 'Filetti di trota iridea salmonata confezione risparmio', 'Italia', 6, 20),
(23, 'Scampi, 200 gr.', 'pesce', 'Pescato in Oceano Atlantico Nord Orientale nelle possibili seguenti divisioni di pesca: Skagerrak e Kattegat; Belt; Mar Baltico; Mare del Nord settentrionale; Mare del Nord centrale, Mare del Nord meridionale, Mar d\'Irlanda, Fondali ad occidente dell\'Irlanda, Banco del Porcupine, la Manica orientale e occidentale, Canale di Bristol, Celtic Sea settentrionale e meridionale e Fondali a sud-ovest dell\'Irlanda- orientali e occidentali; Mar d\'Irlanda; La Manica orientale; La Manica occidentale; acque portoghesi orientali.', 'Oceano Atlantico Nord Orientale', 3.82, 20),
(24, 'Sogliola senza pelle eviscerata, 250 gr.', 'pesce', 'La sogliola (Solea vulgaris) è un pesce pescato in mare della famiglia Soleidae.', 'Oceano Atlantico Nord Orientale', 6.50, 23),
(25, 'Parmigiano reggiano DOP 500 gr, Euroformaggi', 'latte', 'Formaggio Parmigiano Reggiano', 'Busseto (PR), Italia', 7.50, 50),
(26, 'Stracchino Nonno Nanni, 100 gr.', 'latte', 'Formaggio fresco naturalmente ricco in calcio, fosforo e fonte di vitamina A e B12', 'Giavera del Montello (TV), Italia', 1.45, 30),
(27, 'Yogurt alla fragola YOMO', 'latte', 'Yogurt formato famiglia - 4x125gr. Con pura frutta, senza aromi, senza conservanti, senza coloranti, senza addensanti', 'Bologna, Italia', 2.50, 35),
(28, 'Branzino eviscerato 350 gr.', 'pesce', 'Il Branzino o Spigola (Dicentrarchus labrax) è un pesce marino della famiglia Moronidae, allevato o pescato.', 'Sardegna, Italia', 5.90, 23),
(29, 'Riso Riserva Gallo, chicchi grossi', 'pasta', 'Riso caratterizzato da chicchi grossi e corposi capaci di mantecare delicatamente. Ideali per la preparazione di tutti i risotti, dai più tradizionali ai più raffinati. I suoi chicchi rimangono ben sgranati, assorbono i sapori e si legano perfettamente con i diversi ingredienti.', 'Italia', 4.00, 100),
(30, 'Gocciole Pavesi, 500 gr.', 'dolci', 'Biscotti frollini con cioccolato', 'Italia', 2.30, 150),
(31, 'Fiesta Ferrero Classica, 10x360 gr.', 'dolci', 'Tortina all\'arancia con liquore ricoperta al cacao magro. Prodotto di pasticceria', 'Italia', 2.90, 100),
(32, 'Kinder Pinguì, 4x30 gr.', 'dolci', 'Pan di spagna con farcitura al latte e cacao ricoperto di cioccolato extra. Prodotto dolciario.', 'Italia', 1.95, 50),
(33, 'Pizza Margherita Buitoni, surgelata', 'surgelati', 'BUITONI BELLA NAPOLI MARGHERITA è una pizza dall\'impasto ispirato alla tradizione napoletana, lievitata 22 ore e preparata con esperienza e passione nella storica fabbrica di Benevento. Si contraddistingue per il suo impasto soffice e areato all\'interno ma croccante alla base e un cornicione ben pronunciato. Una pizza pregiata, composta da ottime materie prime selezionate che combinano al meglio tradizione ed originalità per una straordinaria esperienza di gusto. Tutto il sapore autentico di una buona margherita dal bordo alto, ispirata alla tradizione napoletana, con aggiunta di mozzarella di latte di bufala e pomodori marinati.', 'Napoli, Italia', 3.99, 25),
(34, 'Cornetto Algida, 5 pezzi', 'surgelati', 'Gelato alla panna, con cialda (13%), copertura al cacao magro (13%) e con granella di nocciole e meringhe (3,5%)', 'Italia', 3.90, 60),
(35, 'Viennetta Algida', 'surgelati', 'Morbido gelato alla vaniglia tra croccanti sfoglie al cacao magro (11%)', 'Italia', 2.90, 50),
(36, 'Magnum Classico, 4 pezzi', 'surgelati', 'Gelato alla vaniglia ricoperto di cioccolato al latte (26%)', 'Italia', 2.90, 50),
(37, 'Pisellini primizie biologici 750 gr.', 'surgelati', 'Pisellini primizia biologici surgelati', 'Italia', 2.85, 30),
(38, 'Baby-Dry Mutandino Pampers 26 pezzi', 'mondobimbo', 'Cambio facile, Novità!, Dai 6 mesi in su, 3 Midi 6-11 Kg, 26 Pannolini, Si indossa come una Mutandina con l\'assorbenza di Pampers', 'Polonia', 11.30, 40),
(39, 'Omogenizzato Plasmon di mela, conf. 4x104 gr', 'mondobimbo', 'Alimento per l\'infanzia omogeneizzato mela. A norma del D.P.R. n. 128 del 7.4.99', 'Italia', 2.60, 30),
(40, 'Latte 1 per lattanti, Aptamil, 500 ml', 'mondobimbo', 'Aptamil 1 è un latte appositamente studiato per soddisfare le esigenze nutrizionali del lattante dalla nascita fino al 6° mese compiuti, quando l\'allattamento al seno non è possibile o sufficiente.', 'Italia', 2.20, 30),
(41, 'Biscotti Plasmon, 480 gr', 'mondobimbo', '8x Confezioni salvagusto, Da 6 mesi, Studiato per le esigenze nutrizionali e con ferro per lo sviluppo cognitivo, Si scioglie in bocca e nel latte, Senza olio di palma', 'Italia', 3.40, 35),
(42, 'Acqua Lete effervescentemente frizzante, 6x1.5L', 'bibite', 'Facilita la digestione, Può avere effetti diuretici, E\' indicata per le diete iposodiche, Microbiologicamente pura', 'Italia', 2.05, 50),
(43, 'Coca Cola, 1.5L', 'bibite', 'Bevanda analcolica gusto caramello', 'Italia', 1.55, 100),
(44, 'Aranciata Fanta, 1.5L', 'bibite', 'Bevanda analcolica gusto arancia', 'Italia', 1.45, 75),
(45, 'Sprite, 1.5L', 'bibite', 'Bevanda analcolica al limone con zucchero ed edulcoranti', 'Italia', 1.50, 50),
(46, 'Cozze, 1 kg', 'pesce', 'Mollusci marini. Prodotto pulito. Da conservarsi a temperatura da 0 a 4 °C, da consumarsi previa cottura', 'Goro (FE), Italia', 4.30, 15),
(47, 'Birra Ichnusa non filtrara, 66 cl', 'alcol', 'Birra di gradazione 5%. Fatta con puro malto d\'orzo, non essendo filtrata, presenta un aspetto velato grazie ai lieviti rimasti in sospensione.', 'Sardegna, Italia', 1, 50),
(48, 'Brunello di Montalcino, Castello di Banfi, DOCG 37.5 cl', 'alcol', 'Brunello di Montalcino, vino della Toscana, Italia. Gradazione 14.5%', 'Toscana, Italia', 14.60, 25),
(49, 'Sale grosso, Gemma di mare, 1kg', 'varie', 'Sale alimentare estratto dall\'acqua di mare non trattato', 'Italia', 0.75, 100),
(50, 'Ragù alla bolognese, Barilla, 295 gr', 'varie', 'Sugo da condimento al ragù, con carne italiana', 'Italia', 1.80, 80)
;
COMMIT;
BEGIN;
INSERT INTO `item` VALUES
(NULL,'Prova alimento vegano 1', 'veggie', 'Descrizione', 'Italia', 1.20, 1),
(NULL,'Prova alimento vegano 2', 'veggie', 'Descrizione', 'Italia', 1.20, 0),
(NULL,'Prova alimento vegano 3', 'veggie', 'Descrizione', 'Italia', 1.20, 3),
(NULL,'Prova alimento vegano 4', 'veggie', 'Descrizione', 'Italia', 1.20, 4),
(NULL,'Prova alimento vegano 5', 'veggie', 'Descrizione', 'Italia', 1.20, 5),
(NULL,'Prova alimento vegano 6', 'veggie', 'Descrizione', 'Italia', 1.20, 6),
(NULL,'Prova alimento vegano 7', 'veggie', 'Descrizione', 'Italia', 1.20, 0),
(NULL,'Prova alimento vegano 8', 'veggie', 'Descrizione', 'Italia', 1.20, 8),
(NULL,'Prova alimento vegano 9', 'veggie', 'Descrizione', 'Italia', 1.20, 9),
(NULL,'Prova alimento vegano 10', 'veggie', 'Descrizione', 'Italia', 1.20, 10),
(NULL,'Prova alimento vegano 11', 'veggie', 'Descrizione', 'Italia', 1.20, 11),
(NULL,'Prova alimento vegano 12', 'veggie', 'Descrizione', 'Italia', 1.20, 0),
(NULL,'Prova alimento vegano 13', 'veggie', 'Descrizione', 'Italia', 1.20, 13),
(NULL,'Prova alimento vegano 14', 'veggie', 'Descrizione', 'Italia', 1.20, 14),
(NULL,'Prova alimento vegano 15', 'veggie', 'Descrizione', 'Italia', 1.20, 15),
(NULL,'Prova alimento vegano 16', 'veggie', 'Descrizione', 'Italia', 1.20, 16),
(NULL,'Prova alimento vegano 17', 'veggie', 'Descrizione', 'Italia', 1.20, 17),
(NULL,'Prova alimento vegano 18', 'veggie', 'Descrizione', 'Italia', 1.20, 18),
(NULL,'Prova alimento vegano 19', 'veggie', 'Descrizione', 'Italia', 1.20, 19),
(NULL,'Prova alimento vegano 20', 'veggie', 'Descrizione', 'Italia', 1.20, 20),
(NULL,'Prova alimento vegano 21', 'veggie', 'Descrizione', 'Italia', 1.20, 21),
(NULL,'Prova alimento vegano 22', 'veggie', 'Descrizione', 'Italia', 1.20, 22),
(NULL,'Prova alimento vegano 23', 'veggie', 'Descrizione', 'Italia', 1.20, 23),
(NULL,'Prova alimento vegano 24', 'veggie', 'Descrizione', 'Italia', 1.20, 24),
(NULL,'Prova alimento vegano 25', 'veggie', 'Descrizione', 'Italia', 1.20, 25),
(NULL,'Prova alimento vegano 26', 'veggie', 'Descrizione', 'Italia', 1.20, 26),
(NULL,'Prova alimento vegano 27', 'veggie', 'Descrizione', 'Italia', 1.20, 27),
(NULL,'Prova alimento vegano 28', 'veggie', 'Descrizione', 'Italia', 1.20, 28),
(NULL,'Prova alimento vegano 29', 'veggie', 'Descrizione', 'Italia', 1.20, 29),
(NULL,'Prova alimento vegano 30', 'veggie', 'Descrizione', 'Italia', 1.20, 30),
(NULL,'Prova alimento vegano 31', 'veggie', 'Descrizione', 'Italia', 1.20, 31),
(NULL,'Prova alimento vegano 32', 'veggie', 'Descrizione', 'Italia', 1.20, 32),
(NULL,'Prova alimento vegano 33', 'veggie', 'Descrizione', 'Italia', 1.20, 33),
(NULL,'Prova alimento vegano 34', 'veggie', 'Descrizione', 'Italia', 1.20, 34),
(NULL,'Prova alimento vegano 35', 'veggie', 'Descrizione', 'Italia', 1.20, 35),
(NULL,'Prova alimento vegano 36', 'veggie', 'Descrizione', 'Italia', 1.20, 36),
(NULL,'Prova alimento vegano 37', 'veggie', 'Descrizione', 'Italia', 1.20, 37),
(NULL,'Prova alimento vegano 38', 'veggie', 'Descrizione', 'Italia', 1.20, 38),
(NULL,'Prova alimento vegano 39', 'veggie', 'Descrizione', 'Italia', 1.20, 39),
(NULL,'Prova alimento vegano 40', 'veggie', 'Descrizione', 'Italia', 1.20, 40),
(NULL,'Prova alimento vegano 41', 'veggie', 'Descrizione', 'Italia', 1.20, 41),
(NULL,'Prova alimento vegano 42', 'veggie', 'Descrizione', 'Italia', 1.20, 42),
(NULL,'Prova alimento vegano 43', 'veggie', 'Descrizione', 'Italia', 1.20, 43),
(NULL,'Prova alimento vegano 44', 'veggie', 'Descrizione', 'Italia', 1.20, 44),
(NULL,'Prova alimento vegano 45', 'veggie', 'Descrizione', 'Italia', 1.20, 45),
(NULL,'Prova alimento vegano 46', 'veggie', 'Descrizione', 'Italia', 1.20, 46),
(NULL,'Prova alimento vegano 47', 'veggie', 'Descrizione', 'Italia', 1.20, 47),
(NULL,'Prova alimento vegano 48', 'veggie', 'Descrizione', 'Italia', 1.20, 48),
(NULL,'Prova alimento vegano 49', 'veggie', 'Descrizione', 'Italia', 1.20, 49),
(NULL,'Prova alimento vegano 50', 'veggie', 'Descrizione', 'Italia', 1.20, 50);
COMMIT;
BEGIN;
INSERT INTO `recensione` VALUES
(2,2,'2019-02-09 14:00:04',4,'Buono'),
(2,3,'2019-02-09 15:12:27',4,'Succose e gustose. Buone!'),
(2,4,'2019-02-09 15:13:34',5,'Amo le mele Fuji e queste in particolare'),
(2,8,'2019-02-09 15:14:04',3,'Buone, senza infamia e senza lode'),
(2,9,'2019-02-09 15:12:59',2,'Aspre e cattive. Sconsiglio l\'acquisto'),
(3,2,'2019-02-09 15:00:04',5,'Buonissimo'),
(4,1,'2019-02-09 14:58:19',4,'Pomodori polposi, da cui estrarre un buon sugo'),
(4,3,'2019-02-09 14:57:30',5,'Ottime arance, perfette per una carica di vitamina C'),
(4,4,'2019-02-09 15:00:45',3,'Qualità  mediocre, speravo di meglio'),
(4,5,'2019-02-09 15:03:11',5,'Mia moglie non mangierebbe altro. 5 stelle!'),
(4,6,'2019-02-09 15:07:21',2,'Qualità un po\' così così. Mi aspettavo di meglio'),
(4,7,'2019-02-09 15:06:32',3,'Buone cipolle per il soffritto, ma niente di più'),
(4,8,'2019-02-09 15:02:48',4,'Buona qualità'),
(4,9,'2019-02-09 15:03:46',1,'Mi sono arrivate troppo acerbe: molto male!'),
(4,10,'2019-02-09 15:06:53',5,'Semplicemente perfetta'),
(4,12,'2019-02-09 15:05:22',5,'Barilla non si smentisce mai: sono perfetti!'),
(4,13,'2019-02-09 15:05:59',4,'Buona qualità , ottima l\'assenza di strutto e olio di palma'),
(4,15,'2019-02-09 15:01:23',2,'Pessima qualità . Non me l\'aspettavo da un marchio famoso.'),
(4,17,'2019-02-09 15:01:50',5,'Ottime uova, ci ho fatto una frittata stupenda'),
(4,18,'2019-02-09 15:04:55',4,'Buono nel riso freddo'),
(4,20,'2019-02-09 15:02:28',4,'Non c\'è¨ che dire, è semplice latte')
;
COMMIT;

BEGIN;
REPLACE INTO `shoppingcart` VALUES
(1,1,'2019-02-09 15:16:41',NULL,NULL,NULL,NULL,NULL),
(2,5,'2019-02-09 15:18:23','2019-02-09 15:20:45',43.80,'via Fratti, 15','Viareggio','55049')
;
COMMIT;

BEGIN;
INSERT INTO `itemtaken` VALUES
(2,1,1),(2,2,1),(2,3,1),(2,4,1),(2,9,1),(2,11,1),(2,12,10),(2,13,5),(2,16,1),(2,17,1),(2,20,3)
;
COMMIT;

BEGIN;
INSERT INTO `costanti` VALUES
(1, 'Spese di spedizione', 2.90);
COMMIT;

-- --------------------------------------------------------
-- 						TRIGGERS	
-- --------------------------------------------------------
SET FOREIGN_KEY_CHECKS = 1;
SET GLOBAL AUTOCOMMIT = 1;
SET GLOBAL EVENT_SCHEDULER = 1;
DELIMITER $$

-- ----------------------------
--  Aggiorna la disponibilita di un oggetto
-- ----------------------------
DROP TRIGGER IF EXISTS insert_itemtaken_after$$
CREATE TRIGGER insert_itemtaken_after
AFTER INSERT ON itemtaken
FOR EACH ROW
BEGIN
	DECLARE thisItem INT UNSIGNED;
    SET thisItem = new.itemID;
	
	UPDATE item
	SET disponibilita = disponibilita - new.howMany
	WHERE itemID = thisItem;
END$$

-- ----------------------------
--  Aggiorna la disponibilita di un oggetto
-- ----------------------------
DROP TRIGGER IF EXISTS update_itemtaken_after$$
CREATE TRIGGER update_itemtaken_after
AFTER UPDATE ON itemtaken
FOR EACH ROW
BEGIN	
	IF(new.itemID <> old.itemID
		OR new.shoppingID <> old.shoppingID)
	THEN
		SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Non puoi modificare la chiave primaria';
    END IF;
    
    UPDATE item
	SET disponibilita = disponibilita + old.howMany - new.howMany
	WHERE itemID = old.itemID;
END$$

-- ----------------------------
--  Aggiorna la disponibilita di un oggetto
-- ----------------------------
DROP TRIGGER IF EXISTS delete_itemtaken_after$$
CREATE TRIGGER delet_itemtaken_after
AFTER DELETE ON itemtaken
FOR EACH ROW
BEGIN	
	UPDATE item
	SET disponibilita = disponibilita + old.howMany
	WHERE itemID = old.itemID;
END$$

-- ----------------------------
-- 	Insert Recensione
-- ----------------------------
DROP TRIGGER IF EXISTS insert_recensione$$
CREATE TRIGGER insert_recensione
BEFORE INSERT ON recensione
FOR EACH ROW
BEGIN
	IF new.Votazione <= 0 || new.Votazione > 5 THEN
		SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La votazione deve essere tra 1 e 5';
	END IF;
END$$

-- ----------------------------
-- 	Controlla l'eta di un utente
-- ----------------------------
DROP TRIGGER IF EXISTS insert_user$$
CREATE TRIGGER insert_user
BEFORE INSERT ON user
FOR EACH ROW
BEGIN
	IF new.DataNascita + INTERVAL 18 YEAR >= CURRENT_DATE THEN
		SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'L\'utente deve essere maggiorenne';
    END IF;
END$$

-- ----------------------------
--  
-- ----------------------------
DROP TRIGGER IF EXISTS insert_shopping_cart$$
CREATE TRIGGER insert_shopping_cart
BEFORE INSERT ON ShoppingCart
FOR EACH ROW
BEGIN
	SET new.TimestampChiusura = NULL;
	SET new.Costo = NULL;
	SET new.Indirizzo = NULL;
	SET new.Citta = NULL;
	SET new.CAP = NULL;
END$$

-- ----------------------------
--  
-- ----------------------------
DROP TRIGGER IF EXISTS update_shopping_cart$$
CREATE TRIGGER update_shopping_cart
BEFORE UPDATE ON ShoppingCart
FOR EACH ROW
BEGIN
	DECLARE userIndirizzo VARCHAR(64);
    DECLARE userCitta VARCHAR(64);
    DECLARE userCAP CHAR(5);
    DECLARE shoppingCosto FLOAT(7,2) UNSIGNED;
    DECLARE spedizione FLOAT;
    
	IF new.TimestampChiusura IS NOT NULL
		AND old.TimestampChiusura IS NULL
	THEN
		SELECT Indirizzo, Citta, CAP
			INTO userIndirizzo, userCitta, userCAP
		FROM user
		WHERE userId = new.userId;
		
        SET new.Indirizzo = userIndirizzo;
        SET new.Citta = userCitta;
        SET new.CAP = userCAP;
        
		SELECT SUM(i.Costo * t.howMany)
			INTO shoppingCosto
        FROM itemtaken t
			INNER JOIN
            item i USING(itemId)
		WHERE t.shoppingId = new.ShoppingId;
        
        SELECT Valore INTO spedizione
        FROM costanti
        WHERE id = 1;
        
        SET new.Costo = shoppingCosto + spedizione;
	END IF;
END$$

-- --------------------------------------------------------
-- 					STORED FUNCTIONS
-- --------------------------------------------------------
-- ----------------------------
-- Calcola la media delle recensioni di un prodotto
-- ----------------------------
DROP FUNCTION IF EXISTS itemsRate$$
CREATE FUNCTION itemsRate(_itemID INT UNSIGNED)
RETURNS FLOAT NOT DETERMINISTIC
BEGIN
	DECLARE averageRate FLOAT DEFAULT 0;
	DECLARE decimalPart INT DEFAULT 0;
	
	SELECT SUM(Votazione)/COUNT(*) INTO averageRate
	FROM Recensione
	WHERE ProdottoRecensito = _itemID;
	
	-- approssima il rating a multipli di 0.5
	SET averageRate = FLOOR(averageRate * 2 + 0.5)/2;
    
    RETURN averageRate;
END$$

DELIMITER ;