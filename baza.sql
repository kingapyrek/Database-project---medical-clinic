

CREATE FUNCTION public.dodaj_lekarz_poradnia(id_lek integer, id_por integer) RETURNS void
    LANGUAGE plpgsql
    AS $_$
BEGIN
    INSERT INTO lekarz_poradnia(id_poradnia, id_lekarz)
    VALUES ($2, $1);
END;
$_$;


ALTER FUNCTION public.dodaj_lekarz_poradnia(id_lek integer, id_por integer) OWNER TO cjsniglj;

--
-- TOC entry 983 (class 1255 OID 3234058)
-- Name: dodaj_pacjent_dolegliwosc(integer, integer); Type: FUNCTION; Schema: public; Owner: cjsniglj
--

CREATE FUNCTION public.dodaj_pacjent_dolegliwosc(id_pacjent integer, id_dolegliwosc integer) RETURNS void
    LANGUAGE plpgsql
    AS $_$
BEGIN
    INSERT INTO pacjent_dolegliwosc(id_pacjent, id_dolegliwosc)
    VALUES ($1, $2);
END;
$_$;


ALTER FUNCTION public.dodaj_pacjent_dolegliwosc(id_pacjent integer, id_dolegliwosc integer) OWNER TO cjsniglj;

--
-- TOC entry 985 (class 1255 OID 3234066)
-- Name: dostepnosc_dyzuru(integer); Type: FUNCTION; Schema: public; Owner: cjsniglj
--

CREATE FUNCTION public.dostepnosc_dyzuru(id_dyz integer) RETURNS boolean
    LANGUAGE plpgsql
    AS $_$
DECLARE
	mozliwe int;
    zajete int;
BEGIN
     SELECT into mozliwe cast(extract(epoch from (koniec - poczatek)/30) as integer)/60 FROM dyzur where id_dyzur=$1;
     SELECT into zajete count(*) from wizyta where id_dyzur=$1 GROUP BY id_dyzur;
    IF (mozliwe is distinct from zajete) THEN
    	RETURN TRUE;
    ELSE
    	RETURN FALSE;
    END IF;
END;
$_$;


ALTER FUNCTION public.dostepnosc_dyzuru(id_dyz integer) OWNER TO cjsniglj;

--
-- TOC entry 988 (class 1255 OID 3244226)
-- Name: lek_dodaj(); Type: FUNCTION; Schema: public; Owner: cjsniglj
--

CREATE FUNCTION public.lek_dodaj() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
DECLARE
BEGIN
    IF EXISTS (
        SELECT
            *
        FROM
            lek
        WHERE
            lek.nazwa = NEW.nazwa AND
           	lek.substancja = NEW.substancja
    ) Then
	   RETURN NULL;   
    END IF;
    RETURN NEW;
END;
$$;


ALTER FUNCTION public.lek_dodaj() OWNER TO cjsniglj;

SET default_tablespace = '';

--
-- TOC entry 245 (class 1259 OID 3232776)
-- Name: lekarz_poradnia; Type: TABLE; Schema: public; Owner: cjsniglj
--

CREATE TABLE public.lekarz_poradnia (
    id_poradnia integer NOT NULL,
    id_lekarz integer NOT NULL
);


ALTER TABLE public.lekarz_poradnia OWNER TO cjsniglj;

--
-- TOC entry 981 (class 1255 OID 3234056)
-- Name: sprawdz_lekarz_poradnia(integer, integer); Type: FUNCTION; Schema: public; Owner: cjsniglj
--

CREATE FUNCTION public.sprawdz_lekarz_poradnia(id_lek integer, id_por integer) RETURNS SETOF public.lekarz_poradnia
    LANGUAGE plpgsql
    AS $_$
BEGIN		
		RETURN QUERY
		SELECT *
		FROM lekarz_poradnia 
		WHERE id_lekarz = $1 AND id_poradnia=$2;
END;
$_$;


ALTER FUNCTION public.sprawdz_lekarz_poradnia(id_lek integer, id_por integer) OWNER TO cjsniglj;

--
-- TOC entry 987 (class 1255 OID 3263685)
-- Name: usun_lekarz(); Type: FUNCTION; Schema: public; Owner: cjsniglj
--

CREATE FUNCTION public.usun_lekarz() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
	DELETE FROM lekarz_poradnia WHERE id_lekarz = old.id_lekarz;
	DELETE FROM lekarz_specjalizacja WHERE id_lekarz = old.id_lekarz;
	DELETE FROM wizyta WHERE id_dyzur = (SELECT id_dyzur from dyzur where id_lekarz = old.id_lekarz);
	DELETE FROM e_recepta_lek WHERE id_e_recepta = (SELECT id_e_recepta from e_recepta where id_lekarz = old.id_lekarz);
	DELETE FROM dyzur WHERE id_lekarz = old.id_lekarz;
	DELETE FROM e_recepta WHERE id_lekarz = old.id_lekarz;
    RETURN OLD;                                                       
END;
$$;


ALTER FUNCTION public.usun_lekarz() OWNER TO cjsniglj;

--
-- TOC entry 984 (class 1255 OID 3234059)
-- Name: usun_pacjent_dolegliwosc(); Type: FUNCTION; Schema: public; Owner: cjsniglj
--

CREATE FUNCTION public.usun_pacjent_dolegliwosc() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
	DELETE FROM pacjent_dolegliwosc WHERE id_dolegliwosc = old.id_dolegliwosc;
    RETURN NULL;                                                       
END;
$$;


ALTER FUNCTION public.usun_pacjent_dolegliwosc() OWNER TO cjsniglj;

--
-- TOC entry 989 (class 1255 OID 3273063)
-- Name: valid_dane(); Type: FUNCTION; Schema: public; Owner: cjsniglj
--

CREATE FUNCTION public.valid_dane() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
    BEGIN
    IF LENGTH(NEW.login) < 3 THEN
        RAISE EXCEPTION 'Za króki login!.';
    END IF;
	IF (select exists(select 1 from pacjent where login = new.login)) THEN
        RAISE EXCEPTION 'Taki login już istnieje!';
    END IF;
	IF (LENGTH(NEW.haslo)) < 6 THEN
        RAISE EXCEPTION 'Za krótkie hasło!';
    END IF;
	IF  NEW.email NOT LIKE '%_@__%.__%'
		THEN RAISE EXCEPTION 'Niepoprawny adres e-mail.';
	END IF;
	IF LENGTH(NEW.imie) < 2 THEN
        RAISE EXCEPTION 'Za krótkie imię!';
    END IF;
	IF LENGTH(NEW.nazwisko) < 2 THEN
        RAISE EXCEPTION 'Za krótkie nazwisko!';
    END IF;
	IF left(NEW.imie, 1) = upper(left(NEW.imie,1)) AND RIGHT(NEW.imie, length(NEW.imie)-1) = lower(RIGHT(NEW.imie, length(NEW.imie)-1)) THEN
   		NEW.imie := NEW.imie;
	ELSE
    	RAISE EXCEPTION 'Imię i nazwisko powinno zaczynać się wielką literą! (reszta małe litery)';  
    END IF;
    IF left(NEW.nazwisko, 1) = upper(left(NEW.nazwisko,1)) AND RIGHT(NEW.nazwisko, length(NEW.nazwisko)-1) = lower(RIGHT(NEW.nazwisko, length(NEW.nazwisko)-1)) THEN
    	NEW.nazwisko := NEW.nazwisko;	
    ELSE
    	RAISE EXCEPTION 'Imię i nazwisko powinno zaczynać się wielką literą! (reszta małe litery)';  
    END IF;
	IF NEW.pesel ~'[0-9]{11}' THEN
		NEW.pesel := NEW.pesel;
	ELSE
        RAISE EXCEPTION 'Pesel powinien zawierać 11 cyfr!';
    END IF;
  
    RETURN NEW;                                                          
    END;
    $$;


ALTER FUNCTION public.valid_dane() OWNER TO cjsniglj;

--
-- TOC entry 238 (class 1259 OID 3232738)
-- Name: lekarz; Type: TABLE; Schema: public; Owner: cjsniglj
--

CREATE TABLE public.lekarz (
    id_lekarz integer NOT NULL,
    imie character varying(30) NOT NULL,
    nazwisko character varying(30) NOT NULL,
    email character varying(40) NOT NULL,
    telefon character varying NOT NULL,
    pesel character varying NOT NULL,
    login character varying NOT NULL,
    haslo character varying NOT NULL
);


ALTER TABLE public.lekarz OWNER TO cjsniglj;

--
-- TOC entry 227 (class 1259 OID 3232678)
-- Name: placowka; Type: TABLE; Schema: public; Owner: cjsniglj
--

CREATE TABLE public.placowka (
    id_placowka integer NOT NULL,
    nazwa character varying NOT NULL,
    id_adres integer NOT NULL
);


ALTER TABLE public.placowka OWNER TO cjsniglj;

--
-- TOC entry 244 (class 1259 OID 3232770)
-- Name: poradnia; Type: TABLE; Schema: public; Owner: cjsniglj
--

CREATE TABLE public.poradnia (
    id_poradnia integer NOT NULL,
    id_placowka integer NOT NULL,
    budynek character varying(4) NOT NULL,
    pietro integer NOT NULL,
    id_typ integer NOT NULL
);


ALTER TABLE public.poradnia OWNER TO cjsniglj;

--
-- TOC entry 225 (class 1259 OID 3232667)
-- Name: poradnia_typ; Type: TABLE; Schema: public; Owner: cjsniglj
--

CREATE TABLE public.poradnia_typ (
    id_typ integer NOT NULL,
    nazwa character varying NOT NULL,
    opis character varying NOT NULL
);


ALTER TABLE public.poradnia_typ OWNER TO cjsniglj;

--
-- TOC entry 252 (class 1259 OID 3234050)
-- Name: lekarz_poradnia_placowka; Type: VIEW; Schema: public; Owner: cjsniglj
--

CREATE VIEW public.lekarz_poradnia_placowka AS
 SELECT lekarz.id_lekarz,
    lekarz.imie,
    lekarz.nazwisko,
    poradnia.id_poradnia,
    poradnia.id_typ,
    poradnia_typ.nazwa,
    placowka.id_placowka
   FROM ((((public.lekarz
     JOIN public.lekarz_poradnia ON ((lekarz_poradnia.id_lekarz = lekarz.id_lekarz)))
     JOIN public.poradnia ON ((poradnia.id_poradnia = lekarz_poradnia.id_poradnia)))
     JOIN public.poradnia_typ ON ((poradnia_typ.id_typ = poradnia.id_typ)))
     JOIN public.placowka ON ((placowka.id_placowka = poradnia.id_placowka)));


ALTER TABLE public.lekarz_poradnia_placowka OWNER TO cjsniglj;

--
-- TOC entry 986 (class 1255 OID 3234055)
-- Name: wyswietl_lekarz_poradnia(integer, integer); Type: FUNCTION; Schema: public; Owner: cjsniglj
--

CREATE FUNCTION public.wyswietl_lekarz_poradnia(id_plac integer, id_por integer) RETURNS SETOF public.lekarz_poradnia_placowka
    LANGUAGE plpgsql
    AS $_$
BEGIN
   RETURN QUERY	
		SELECT * 
		FROM lekarz_poradnia_placowka 
		WHERE id_placowka = $1 AND id_poradnia=$2;
END;
$_$;


ALTER FUNCTION public.wyswietl_lekarz_poradnia(id_plac integer, id_por integer) OWNER TO cjsniglj;

--
-- TOC entry 223 (class 1259 OID 3232656)
-- Name: adres; Type: TABLE; Schema: public; Owner: cjsniglj
--

CREATE TABLE public.adres (
    id_adres integer NOT NULL,
    miasto character varying NOT NULL,
    ulica character varying NOT NULL,
    numer character varying NOT NULL,
    kod_pocztowy character varying NOT NULL
);


ALTER TABLE public.adres OWNER TO cjsniglj;

--
-- TOC entry 222 (class 1259 OID 3232654)
-- Name: adres_id_adres_seq_2; Type: SEQUENCE; Schema: public; Owner: cjsniglj
--

CREATE SEQUENCE public.adres_id_adres_seq_2
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.adres_id_adres_seq_2 OWNER TO cjsniglj;

--
-- TOC entry 4252 (class 0 OID 0)
-- Dependencies: 222
-- Name: adres_id_adres_seq_2; Type: SEQUENCE OWNED BY; Schema: public; Owner: cjsniglj
--

ALTER SEQUENCE public.adres_id_adres_seq_2 OWNED BY public.adres.id_adres;


--
-- TOC entry 231 (class 1259 OID 3232700)
-- Name: dolegliwosc; Type: TABLE; Schema: public; Owner: cjsniglj
--

CREATE TABLE public.dolegliwosc (
    id_dolegliwosc integer NOT NULL,
    nazwa character varying NOT NULL,
    opis character varying NOT NULL
);


ALTER TABLE public.dolegliwosc OWNER TO cjsniglj;

--
-- TOC entry 230 (class 1259 OID 3232698)
-- Name: dolegliwosc_id_dolegliwosc_seq; Type: SEQUENCE; Schema: public; Owner: cjsniglj
--

CREATE SEQUENCE public.dolegliwosc_id_dolegliwosc_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dolegliwosc_id_dolegliwosc_seq OWNER TO cjsniglj;

--
-- TOC entry 4253 (class 0 OID 0)
-- Dependencies: 230
-- Name: dolegliwosc_id_dolegliwosc_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: cjsniglj
--

ALTER SEQUENCE public.dolegliwosc_id_dolegliwosc_seq OWNED BY public.dolegliwosc.id_dolegliwosc;


--
-- TOC entry 249 (class 1259 OID 3232791)
-- Name: dyzur; Type: TABLE; Schema: public; Owner: cjsniglj
--

CREATE TABLE public.dyzur (
    id_dyzur integer NOT NULL,
    id_lekarz integer NOT NULL,
    dzien date NOT NULL,
    poczatek time without time zone NOT NULL,
    koniec time without time zone NOT NULL,
    id_gabinet integer NOT NULL
);


ALTER TABLE public.dyzur OWNER TO cjsniglj;

--
-- TOC entry 248 (class 1259 OID 3232789)
-- Name: dyzur_id_dyzur_seq_1; Type: SEQUENCE; Schema: public; Owner: cjsniglj
--

CREATE SEQUENCE public.dyzur_id_dyzur_seq_1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dyzur_id_dyzur_seq_1 OWNER TO cjsniglj;

--
-- TOC entry 4254 (class 0 OID 0)
-- Dependencies: 248
-- Name: dyzur_id_dyzur_seq_1; Type: SEQUENCE OWNED BY; Schema: public; Owner: cjsniglj
--

ALTER SEQUENCE public.dyzur_id_dyzur_seq_1 OWNED BY public.dyzur.id_dyzur;


--
-- TOC entry 241 (class 1259 OID 3232754)
-- Name: e_recepta; Type: TABLE; Schema: public; Owner: cjsniglj
--

CREATE TABLE public.e_recepta (
    id_e_recepta integer NOT NULL,
    id_pacjent integer NOT NULL,
    id_lekarz integer NOT NULL,
    kod integer NOT NULL
);


ALTER TABLE public.e_recepta OWNER TO cjsniglj;

--
-- TOC entry 240 (class 1259 OID 3232752)
-- Name: e_recepta_id_e_recepta_seq; Type: SEQUENCE; Schema: public; Owner: cjsniglj
--

CREATE SEQUENCE public.e_recepta_id_e_recepta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.e_recepta_id_e_recepta_seq OWNER TO cjsniglj;

--
-- TOC entry 4255 (class 0 OID 0)
-- Dependencies: 240
-- Name: e_recepta_id_e_recepta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: cjsniglj
--

ALTER SEQUENCE public.e_recepta_id_e_recepta_seq OWNED BY public.e_recepta.id_e_recepta;


--
-- TOC entry 242 (class 1259 OID 3232760)
-- Name: e_recepta_lek; Type: TABLE; Schema: public; Owner: cjsniglj
--

CREATE TABLE public.e_recepta_lek (
    id_lek integer NOT NULL,
    id_e_recepta integer NOT NULL,
    dawkowanie character varying NOT NULL
);


ALTER TABLE public.e_recepta_lek OWNER TO cjsniglj;

--
-- TOC entry 247 (class 1259 OID 3232783)
-- Name: gabinet; Type: TABLE; Schema: public; Owner: cjsniglj
--

CREATE TABLE public.gabinet (
    id_gabinet integer NOT NULL,
    numer integer NOT NULL,
    id_poradnia integer NOT NULL
);


ALTER TABLE public.gabinet OWNER TO cjsniglj;

--
-- TOC entry 246 (class 1259 OID 3232781)
-- Name: gabinet_id_gabinet_seq; Type: SEQUENCE; Schema: public; Owner: cjsniglj
--

CREATE SEQUENCE public.gabinet_id_gabinet_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.gabinet_id_gabinet_seq OWNER TO cjsniglj;

--
-- TOC entry 4256 (class 0 OID 0)
-- Dependencies: 246
-- Name: gabinet_id_gabinet_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: cjsniglj
--

ALTER SEQUENCE public.gabinet_id_gabinet_seq OWNED BY public.gabinet.id_gabinet;


--
-- TOC entry 229 (class 1259 OID 3232689)
-- Name: lek; Type: TABLE; Schema: public; Owner: cjsniglj
--

CREATE TABLE public.lek (
    id_lek integer NOT NULL,
    nazwa character varying NOT NULL,
    substancja character varying NOT NULL
);


ALTER TABLE public.lek OWNER TO cjsniglj;

--
-- TOC entry 228 (class 1259 OID 3232687)
-- Name: lek_id_lek_seq; Type: SEQUENCE; Schema: public; Owner: cjsniglj
--

CREATE SEQUENCE public.lek_id_lek_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.lek_id_lek_seq OWNER TO cjsniglj;

--
-- TOC entry 4257 (class 0 OID 0)
-- Dependencies: 228
-- Name: lek_id_lek_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: cjsniglj
--

ALTER SEQUENCE public.lek_id_lek_seq OWNED BY public.lek.id_lek;


--
-- TOC entry 253 (class 1259 OID 3234061)
-- Name: lekarz_dyzury; Type: VIEW; Schema: public; Owner: cjsniglj
--

CREATE VIEW public.lekarz_dyzury AS
 SELECT lekarz.id_lekarz,
    lekarz.imie,
    lekarz.nazwisko,
    poradnia_typ.nazwa AS poradnia_nazwa,
    poradnia.budynek,
    poradnia.pietro,
    placowka.nazwa AS placowka_nazwa,
    poradnia.id_poradnia,
    dyzur.id_dyzur,
    dyzur.dzien,
    dyzur.poczatek,
    dyzur.koniec,
    gabinet.numer
   FROM ((((((public.dyzur
     JOIN public.lekarz ON ((dyzur.id_lekarz = lekarz.id_lekarz)))
     JOIN public.lekarz_poradnia ON ((lekarz_poradnia.id_lekarz = lekarz.id_lekarz)))
     JOIN public.poradnia ON ((poradnia.id_poradnia = lekarz_poradnia.id_poradnia)))
     JOIN public.poradnia_typ ON ((poradnia_typ.id_typ = poradnia.id_typ)))
     JOIN public.placowka ON ((placowka.id_placowka = poradnia.id_placowka)))
     JOIN public.gabinet ON (((gabinet.id_gabinet = dyzur.id_gabinet) AND (gabinet.id_poradnia = poradnia.id_poradnia))));


ALTER TABLE public.lekarz_dyzury OWNER TO cjsniglj;

--
-- TOC entry 237 (class 1259 OID 3232736)
-- Name: lekarz_id_lekarz_seq; Type: SEQUENCE; Schema: public; Owner: cjsniglj
--

CREATE SEQUENCE public.lekarz_id_lekarz_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.lekarz_id_lekarz_seq OWNER TO cjsniglj;

--
-- TOC entry 4258 (class 0 OID 0)
-- Dependencies: 237
-- Name: lekarz_id_lekarz_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: cjsniglj
--

ALTER SEQUENCE public.lekarz_id_lekarz_seq OWNED BY public.lekarz.id_lekarz;


--
-- TOC entry 235 (class 1259 OID 3232722)
-- Name: pacjent; Type: TABLE; Schema: public; Owner: cjsniglj
--

CREATE TABLE public.pacjent (
    id_pacjent integer NOT NULL,
    imie character varying(30) NOT NULL,
    nazwisko character varying(30) NOT NULL,
    data_urodzenia date NOT NULL,
    email character varying(40) NOT NULL,
    pesel character varying NOT NULL,
    id_adres integer NOT NULL,
    login character varying NOT NULL,
    haslo character varying NOT NULL
);


ALTER TABLE public.pacjent OWNER TO cjsniglj;

--
-- TOC entry 251 (class 1259 OID 3232799)
-- Name: wizyta; Type: TABLE; Schema: public; Owner: cjsniglj
--

CREATE TABLE public.wizyta (
    id_wizyta integer NOT NULL,
    godzina time without time zone NOT NULL,
    data date NOT NULL,
    id_pacjent integer NOT NULL,
    id_dyzur integer NOT NULL
);


ALTER TABLE public.wizyta OWNER TO cjsniglj;

--
-- TOC entry 257 (class 1259 OID 3242364)
-- Name: lekarz_pacjenci; Type: VIEW; Schema: public; Owner: cjsniglj
--

CREATE VIEW public.lekarz_pacjenci AS
 SELECT DISTINCT pacjent.id_pacjent,
    dyzur.id_lekarz,
    pacjent.imie,
    pacjent.nazwisko,
    pacjent.data_urodzenia,
    pacjent.email,
    pacjent.pesel
   FROM ((public.pacjent
     JOIN public.wizyta ON ((wizyta.id_pacjent = pacjent.id_pacjent)))
     JOIN public.dyzur ON ((dyzur.id_dyzur = wizyta.id_dyzur)));


ALTER TABLE public.lekarz_pacjenci OWNER TO cjsniglj;

--
-- TOC entry 259 (class 1259 OID 3244581)
-- Name: lekarz_recepty; Type: VIEW; Schema: public; Owner: cjsniglj
--

CREATE VIEW public.lekarz_recepty AS
 SELECT lek.nazwa,
    lek.substancja,
    e_recepta_lek.dawkowanie,
    pacjent.id_pacjent,
    pacjent.imie,
    pacjent.nazwisko,
    e_recepta.id_lekarz,
    e_recepta.id_e_recepta,
    e_recepta.kod
   FROM (((public.e_recepta
     JOIN public.e_recepta_lek ON ((e_recepta.id_e_recepta = e_recepta_lek.id_e_recepta)))
     JOIN public.lek ON ((lek.id_lek = e_recepta_lek.id_lek)))
     JOIN public.pacjent ON ((e_recepta.id_pacjent = pacjent.id_pacjent)));


ALTER TABLE public.lekarz_recepty OWNER TO cjsniglj;

--
-- TOC entry 239 (class 1259 OID 3232747)
-- Name: lekarz_specjalizacja; Type: TABLE; Schema: public; Owner: cjsniglj
--

CREATE TABLE public.lekarz_specjalizacja (
    id_lekarz integer NOT NULL,
    id_specjalizacja integer NOT NULL
);


ALTER TABLE public.lekarz_specjalizacja OWNER TO cjsniglj;

--
-- TOC entry 256 (class 1259 OID 3242354)
-- Name: lekarz_wizyty; Type: VIEW; Schema: public; Owner: cjsniglj
--

CREATE VIEW public.lekarz_wizyty AS
 SELECT wizyta.id_wizyta,
    wizyta.id_dyzur,
    wizyta.godzina,
    pacjent.id_pacjent,
    pacjent.imie,
    pacjent.nazwisko,
    pacjent.data_urodzenia,
    pacjent.email,
    pacjent.pesel,
    wizyta.data,
    lekarz.id_lekarz,
    gabinet.numer AS numer_gabinet,
    poradnia.budynek,
    poradnia.pietro,
    poradnia_typ.nazwa AS poradnia_nazwa,
    placowka.nazwa AS placowka_nazwa,
    adres.miasto,
    adres.ulica,
    adres.numer AS adres_numer
   FROM ((((((((public.wizyta
     JOIN public.pacjent ON ((pacjent.id_pacjent = wizyta.id_pacjent)))
     JOIN public.dyzur ON ((dyzur.id_dyzur = wizyta.id_dyzur)))
     JOIN public.lekarz ON ((lekarz.id_lekarz = dyzur.id_lekarz)))
     JOIN public.gabinet ON ((gabinet.id_gabinet = dyzur.id_gabinet)))
     JOIN public.poradnia ON ((poradnia.id_poradnia = gabinet.id_poradnia)))
     JOIN public.poradnia_typ ON ((poradnia_typ.id_typ = poradnia.id_typ)))
     JOIN public.placowka ON ((placowka.id_placowka = poradnia.id_placowka)))
     JOIN public.adres ON ((adres.id_adres = placowka.id_adres)));


ALTER TABLE public.lekarz_wizyty OWNER TO cjsniglj;

--
-- TOC entry 236 (class 1259 OID 3232731)
-- Name: pacjent_dolegliwosc; Type: TABLE; Schema: public; Owner: cjsniglj
--

CREATE TABLE public.pacjent_dolegliwosc (
    id_pacjent integer NOT NULL,
    id_dolegliwosc integer NOT NULL
);


ALTER TABLE public.pacjent_dolegliwosc OWNER TO cjsniglj;

--
-- TOC entry 234 (class 1259 OID 3232720)
-- Name: pacjent_id_pacjent_seq; Type: SEQUENCE; Schema: public; Owner: cjsniglj
--

CREATE SEQUENCE public.pacjent_id_pacjent_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pacjent_id_pacjent_seq OWNER TO cjsniglj;

--
-- TOC entry 4259 (class 0 OID 0)
-- Dependencies: 234
-- Name: pacjent_id_pacjent_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: cjsniglj
--

ALTER SEQUENCE public.pacjent_id_pacjent_seq OWNED BY public.pacjent.id_pacjent;


--
-- TOC entry 258 (class 1259 OID 3244495)
-- Name: pacjent_lekarz_recepty; Type: VIEW; Schema: public; Owner: cjsniglj
--

CREATE VIEW public.pacjent_lekarz_recepty AS
 SELECT lek.nazwa,
    lek.substancja,
    e_recepta_lek.dawkowanie,
    e_recepta.id_pacjent,
    e_recepta.id_lekarz,
    e_recepta.id_e_recepta,
    e_recepta.kod
   FROM ((public.e_recepta
     JOIN public.e_recepta_lek ON ((e_recepta.id_e_recepta = e_recepta_lek.id_e_recepta)))
     JOIN public.lek ON ((lek.id_lek = e_recepta_lek.id_lek)));


ALTER TABLE public.pacjent_lekarz_recepty OWNER TO cjsniglj;

--
-- TOC entry 260 (class 1259 OID 3256609)
-- Name: pacjent_recepty; Type: VIEW; Schema: public; Owner: cjsniglj
--

CREATE VIEW public.pacjent_recepty AS
 SELECT lek.nazwa,
    lek.substancja,
    e_recepta_lek.dawkowanie,
    pacjent.id_pacjent,
    e_recepta.id_lekarz,
    lekarz.imie,
    lekarz.nazwisko,
    e_recepta.id_e_recepta,
    e_recepta.kod
   FROM ((((public.e_recepta
     JOIN public.e_recepta_lek ON ((e_recepta.id_e_recepta = e_recepta_lek.id_e_recepta)))
     JOIN public.lek ON ((lek.id_lek = e_recepta_lek.id_lek)))
     JOIN public.pacjent ON ((e_recepta.id_pacjent = pacjent.id_pacjent)))
     JOIN public.lekarz ON ((lekarz.id_lekarz = e_recepta.id_lekarz)));


ALTER TABLE public.pacjent_recepty OWNER TO cjsniglj;

--
-- TOC entry 255 (class 1259 OID 3234072)
-- Name: pacjent_wizyty; Type: VIEW; Schema: public; Owner: cjsniglj
--

CREATE VIEW public.pacjent_wizyty AS
 SELECT wizyta.id_wizyta,
    wizyta.id_dyzur,
    wizyta.godzina,
    wizyta.id_pacjent,
    wizyta.data,
    lekarz.imie,
    lekarz.nazwisko,
    gabinet.numer AS numer_gabinet,
    poradnia.budynek,
    poradnia.pietro,
    poradnia_typ.nazwa AS poradnia_nazwa,
    placowka.nazwa AS placowka_nazwa,
    adres.miasto,
    adres.ulica,
    adres.numer AS adres_numer
   FROM (((((((public.wizyta
     JOIN public.dyzur ON ((dyzur.id_dyzur = wizyta.id_dyzur)))
     JOIN public.lekarz ON ((lekarz.id_lekarz = dyzur.id_lekarz)))
     JOIN public.gabinet ON ((gabinet.id_gabinet = dyzur.id_gabinet)))
     JOIN public.poradnia ON ((poradnia.id_poradnia = gabinet.id_poradnia)))
     JOIN public.poradnia_typ ON ((poradnia_typ.id_typ = poradnia.id_typ)))
     JOIN public.placowka ON ((placowka.id_placowka = poradnia.id_placowka)))
     JOIN public.adres ON ((adres.id_adres = placowka.id_adres)));


ALTER TABLE public.pacjent_wizyty OWNER TO cjsniglj;

--
-- TOC entry 226 (class 1259 OID 3232676)
-- Name: placowka_id_placowka_seq; Type: SEQUENCE; Schema: public; Owner: cjsniglj
--

CREATE SEQUENCE public.placowka_id_placowka_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.placowka_id_placowka_seq OWNER TO cjsniglj;

--
-- TOC entry 4260 (class 0 OID 0)
-- Dependencies: 226
-- Name: placowka_id_placowka_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: cjsniglj
--

ALTER SEQUENCE public.placowka_id_placowka_seq OWNED BY public.placowka.id_placowka;


--
-- TOC entry 243 (class 1259 OID 3232768)
-- Name: poradnia_id_poradnia_seq; Type: SEQUENCE; Schema: public; Owner: cjsniglj
--

CREATE SEQUENCE public.poradnia_id_poradnia_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.poradnia_id_poradnia_seq OWNER TO cjsniglj;

--
-- TOC entry 4261 (class 0 OID 0)
-- Dependencies: 243
-- Name: poradnia_id_poradnia_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: cjsniglj
--

ALTER SEQUENCE public.poradnia_id_poradnia_seq OWNED BY public.poradnia.id_poradnia;


--
-- TOC entry 224 (class 1259 OID 3232665)
-- Name: poradnia_typ_id_typ_seq_1; Type: SEQUENCE; Schema: public; Owner: cjsniglj
--

CREATE SEQUENCE public.poradnia_typ_id_typ_seq_1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.poradnia_typ_id_typ_seq_1 OWNER TO cjsniglj;

--
-- TOC entry 4262 (class 0 OID 0)
-- Dependencies: 224
-- Name: poradnia_typ_id_typ_seq_1; Type: SEQUENCE OWNED BY; Schema: public; Owner: cjsniglj
--

ALTER SEQUENCE public.poradnia_typ_id_typ_seq_1 OWNED BY public.poradnia_typ.id_typ;


--
-- TOC entry 233 (class 1259 OID 3232711)
-- Name: specjalizacja; Type: TABLE; Schema: public; Owner: cjsniglj
--

CREATE TABLE public.specjalizacja (
    id_specjalizacja integer NOT NULL,
    uczelnia character varying NOT NULL,
    nazwa character varying NOT NULL,
    rok_otrzymania integer NOT NULL
);


ALTER TABLE public.specjalizacja OWNER TO cjsniglj;

--
-- TOC entry 232 (class 1259 OID 3232709)
-- Name: specjalizacja_id_specjalizacja_seq; Type: SEQUENCE; Schema: public; Owner: cjsniglj
--

CREATE SEQUENCE public.specjalizacja_id_specjalizacja_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.specjalizacja_id_specjalizacja_seq OWNER TO cjsniglj;

--
-- TOC entry 4263 (class 0 OID 0)
-- Dependencies: 232
-- Name: specjalizacja_id_specjalizacja_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: cjsniglj
--

ALTER SEQUENCE public.specjalizacja_id_specjalizacja_seq OWNED BY public.specjalizacja.id_specjalizacja;


--
-- TOC entry 250 (class 1259 OID 3232797)
-- Name: wizyta_id_wizyta_seq; Type: SEQUENCE; Schema: public; Owner: cjsniglj
--

CREATE SEQUENCE public.wizyta_id_wizyta_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.wizyta_id_wizyta_seq OWNER TO cjsniglj;

--
-- TOC entry 4264 (class 0 OID 0)
-- Dependencies: 250
-- Name: wizyta_id_wizyta_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: cjsniglj
--

ALTER SEQUENCE public.wizyta_id_wizyta_seq OWNED BY public.wizyta.id_wizyta;


--
-- TOC entry 254 (class 1259 OID 3234067)
-- Name: wybor_wizyta; Type: VIEW; Schema: public; Owner: cjsniglj
--

CREATE VIEW public.wybor_wizyta AS
 SELECT dyzur.id_dyzur,
    dyzur.dzien,
    lekarz.imie,
    lekarz.nazwisko,
    gabinet.numer AS numer_gabinet,
    poradnia.budynek,
    poradnia.pietro,
    poradnia_typ.nazwa AS poradnia_nazwa,
    placowka.nazwa AS placowka_nazwa,
    adres.miasto,
    adres.ulica,
    adres.numer AS adres_numer
   FROM ((((((public.dyzur
     JOIN public.lekarz ON ((lekarz.id_lekarz = dyzur.id_lekarz)))
     JOIN public.gabinet ON ((gabinet.id_gabinet = dyzur.id_gabinet)))
     JOIN public.poradnia ON ((poradnia.id_poradnia = gabinet.id_poradnia)))
     JOIN public.poradnia_typ ON ((poradnia_typ.id_typ = poradnia.id_typ)))
     JOIN public.placowka ON ((placowka.id_placowka = poradnia.id_placowka)))
     JOIN public.adres ON ((adres.id_adres = placowka.id_adres)));


ALTER TABLE public.wybor_wizyta OWNER TO cjsniglj;

--
-- TOC entry 261 (class 1259 OID 3259552)
-- Name: wyszukaj_lekarz; Type: VIEW; Schema: public; Owner: cjsniglj
--

CREATE VIEW public.wyszukaj_lekarz AS
 SELECT dyzur.id_dyzur,
    dyzur.id_lekarz,
    dyzur.dzien,
    dyzur.poczatek,
    dyzur.koniec,
    gabinet.id_gabinet,
    gabinet.numer AS gabinet_numer,
    poradnia.budynek,
    poradnia.pietro,
    placowka.nazwa AS placowka_nazwa,
    adres.miasto,
    adres.ulica,
    adres.numer AS adres_numer,
    adres.kod_pocztowy,
    lekarz.imie,
    lekarz.nazwisko,
    specjalizacja.id_specjalizacja,
    specjalizacja.nazwa,
    poradnia_typ.nazwa AS poradnia_typ_nazwa
   FROM ((((((((public.dyzur
     JOIN public.gabinet ON ((gabinet.id_gabinet = dyzur.id_gabinet)))
     JOIN public.poradnia ON ((poradnia.id_poradnia = gabinet.id_poradnia)))
     JOIN public.poradnia_typ ON ((poradnia_typ.id_typ = poradnia.id_typ)))
     JOIN public.placowka ON ((placowka.id_placowka = poradnia.id_placowka)))
     JOIN public.adres ON ((adres.id_adres = placowka.id_adres)))
     JOIN public.lekarz ON ((lekarz.id_lekarz = dyzur.id_lekarz)))
     JOIN public.lekarz_specjalizacja ON ((lekarz_specjalizacja.id_lekarz = lekarz.id_lekarz)))
     JOIN public.specjalizacja ON ((specjalizacja.id_specjalizacja = lekarz_specjalizacja.id_specjalizacja)))
  ORDER BY dyzur.dzien, dyzur.poczatek;


ALTER TABLE public.wyszukaj_lekarz OWNER TO cjsniglj;

--
-- TOC entry 4024 (class 2604 OID 3232659)
-- Name: adres id_adres; Type: DEFAULT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.adres ALTER COLUMN id_adres SET DEFAULT nextval('public.adres_id_adres_seq_2'::regclass);


--
-- TOC entry 4028 (class 2604 OID 3232703)
-- Name: dolegliwosc id_dolegliwosc; Type: DEFAULT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.dolegliwosc ALTER COLUMN id_dolegliwosc SET DEFAULT nextval('public.dolegliwosc_id_dolegliwosc_seq'::regclass);


--
-- TOC entry 4035 (class 2604 OID 3232794)
-- Name: dyzur id_dyzur; Type: DEFAULT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.dyzur ALTER COLUMN id_dyzur SET DEFAULT nextval('public.dyzur_id_dyzur_seq_1'::regclass);


--
-- TOC entry 4032 (class 2604 OID 3232757)
-- Name: e_recepta id_e_recepta; Type: DEFAULT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.e_recepta ALTER COLUMN id_e_recepta SET DEFAULT nextval('public.e_recepta_id_e_recepta_seq'::regclass);


--
-- TOC entry 4034 (class 2604 OID 3232786)
-- Name: gabinet id_gabinet; Type: DEFAULT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.gabinet ALTER COLUMN id_gabinet SET DEFAULT nextval('public.gabinet_id_gabinet_seq'::regclass);


--
-- TOC entry 4027 (class 2604 OID 3232692)
-- Name: lek id_lek; Type: DEFAULT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.lek ALTER COLUMN id_lek SET DEFAULT nextval('public.lek_id_lek_seq'::regclass);


--
-- TOC entry 4031 (class 2604 OID 3232741)
-- Name: lekarz id_lekarz; Type: DEFAULT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.lekarz ALTER COLUMN id_lekarz SET DEFAULT nextval('public.lekarz_id_lekarz_seq'::regclass);


--
-- TOC entry 4030 (class 2604 OID 3232725)
-- Name: pacjent id_pacjent; Type: DEFAULT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.pacjent ALTER COLUMN id_pacjent SET DEFAULT nextval('public.pacjent_id_pacjent_seq'::regclass);


--
-- TOC entry 4026 (class 2604 OID 3232681)
-- Name: placowka id_placowka; Type: DEFAULT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.placowka ALTER COLUMN id_placowka SET DEFAULT nextval('public.placowka_id_placowka_seq'::regclass);


--
-- TOC entry 4033 (class 2604 OID 3232773)
-- Name: poradnia id_poradnia; Type: DEFAULT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.poradnia ALTER COLUMN id_poradnia SET DEFAULT nextval('public.poradnia_id_poradnia_seq'::regclass);


--
-- TOC entry 4025 (class 2604 OID 3232670)
-- Name: poradnia_typ id_typ; Type: DEFAULT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.poradnia_typ ALTER COLUMN id_typ SET DEFAULT nextval('public.poradnia_typ_id_typ_seq_1'::regclass);


--
-- TOC entry 4029 (class 2604 OID 3232714)
-- Name: specjalizacja id_specjalizacja; Type: DEFAULT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.specjalizacja ALTER COLUMN id_specjalizacja SET DEFAULT nextval('public.specjalizacja_id_specjalizacja_seq'::regclass);


--
-- TOC entry 4036 (class 2604 OID 3232802)
-- Name: wizyta id_wizyta; Type: DEFAULT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.wizyta ALTER COLUMN id_wizyta SET DEFAULT nextval('public.wizyta_id_wizyta_seq'::regclass);


--
-- TOC entry 4038 (class 2606 OID 3232664)
-- Name: adres adres_pk; Type: CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.adres
    ADD CONSTRAINT adres_pk PRIMARY KEY (id_adres);


--
-- TOC entry 4046 (class 2606 OID 3232708)
-- Name: dolegliwosc dolegliwosc_pk; Type: CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.dolegliwosc
    ADD CONSTRAINT dolegliwosc_pk PRIMARY KEY (id_dolegliwosc);


--
-- TOC entry 4068 (class 2606 OID 3232796)
-- Name: dyzur dyzur_pk; Type: CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.dyzur
    ADD CONSTRAINT dyzur_pk PRIMARY KEY (id_dyzur);


--
-- TOC entry 4060 (class 2606 OID 3232767)
-- Name: e_recepta_lek e_recepta_lek_pk; Type: CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.e_recepta_lek
    ADD CONSTRAINT e_recepta_lek_pk PRIMARY KEY (id_lek, id_e_recepta);


--
-- TOC entry 4058 (class 2606 OID 3232759)
-- Name: e_recepta e_recepta_pk; Type: CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.e_recepta
    ADD CONSTRAINT e_recepta_pk PRIMARY KEY (id_e_recepta);


--
-- TOC entry 4066 (class 2606 OID 3232788)
-- Name: gabinet gabinet_pk; Type: CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.gabinet
    ADD CONSTRAINT gabinet_pk PRIMARY KEY (id_gabinet);


--
-- TOC entry 4044 (class 2606 OID 3232697)
-- Name: lek lek_pk; Type: CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.lek
    ADD CONSTRAINT lek_pk PRIMARY KEY (id_lek);


--
-- TOC entry 4054 (class 2606 OID 3232746)
-- Name: lekarz lekarz_pk; Type: CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.lekarz
    ADD CONSTRAINT lekarz_pk PRIMARY KEY (id_lekarz);


--
-- TOC entry 4064 (class 2606 OID 3232780)
-- Name: lekarz_poradnia lekarz_poradnia_pk; Type: CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.lekarz_poradnia
    ADD CONSTRAINT lekarz_poradnia_pk PRIMARY KEY (id_poradnia, id_lekarz);


--
-- TOC entry 4056 (class 2606 OID 3232751)
-- Name: lekarz_specjalizacja lekarz_specjalizacja_pk; Type: CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.lekarz_specjalizacja
    ADD CONSTRAINT lekarz_specjalizacja_pk PRIMARY KEY (id_lekarz, id_specjalizacja);


--
-- TOC entry 4052 (class 2606 OID 3232735)
-- Name: pacjent_dolegliwosc pacjent_dolegliwosc_pk; Type: CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.pacjent_dolegliwosc
    ADD CONSTRAINT pacjent_dolegliwosc_pk PRIMARY KEY (id_pacjent, id_dolegliwosc);


--
-- TOC entry 4050 (class 2606 OID 3232730)
-- Name: pacjent pacjent_pk; Type: CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.pacjent
    ADD CONSTRAINT pacjent_pk PRIMARY KEY (id_pacjent);


--
-- TOC entry 4042 (class 2606 OID 3232686)
-- Name: placowka placowka_pk; Type: CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.placowka
    ADD CONSTRAINT placowka_pk PRIMARY KEY (id_placowka);


--
-- TOC entry 4062 (class 2606 OID 3232775)
-- Name: poradnia poradnia_pk; Type: CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.poradnia
    ADD CONSTRAINT poradnia_pk PRIMARY KEY (id_poradnia);


--
-- TOC entry 4040 (class 2606 OID 3232675)
-- Name: poradnia_typ poradnia_typ_pk; Type: CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.poradnia_typ
    ADD CONSTRAINT poradnia_typ_pk PRIMARY KEY (id_typ);


--
-- TOC entry 4048 (class 2606 OID 3232719)
-- Name: specjalizacja specjalizacja_pk; Type: CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.specjalizacja
    ADD CONSTRAINT specjalizacja_pk PRIMARY KEY (id_specjalizacja);


--
-- TOC entry 4070 (class 2606 OID 3232804)
-- Name: wizyta wizyta_pk; Type: CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.wizyta
    ADD CONSTRAINT wizyta_pk PRIMARY KEY (id_wizyta);


--
-- TOC entry 4090 (class 2620 OID 3244227)
-- Name: lek lek_nie_duplikuj; Type: TRIGGER; Schema: public; Owner: cjsniglj
--

CREATE TRIGGER lek_nie_duplikuj BEFORE INSERT ON public.lek FOR EACH ROW EXECUTE PROCEDURE public.lek_dodaj();


--
-- TOC entry 4092 (class 2620 OID 3273064)
-- Name: pacjent pacjent_valid; Type: TRIGGER; Schema: public; Owner: cjsniglj
--

CREATE TRIGGER pacjent_valid BEFORE INSERT ON public.pacjent FOR EACH ROW EXECUTE PROCEDURE public.valid_dane();


--
-- TOC entry 4091 (class 2620 OID 3262826)
-- Name: dolegliwosc usun_dolegliwosc; Type: TRIGGER; Schema: public; Owner: cjsniglj
--

CREATE TRIGGER usun_dolegliwosc BEFORE DELETE ON public.dolegliwosc FOR EACH ROW EXECUTE PROCEDURE public.usun_pacjent_dolegliwosc();


--
-- TOC entry 4093 (class 2620 OID 3263686)
-- Name: lekarz zwolnij_lekarz; Type: TRIGGER; Schema: public; Owner: cjsniglj
--

CREATE TRIGGER zwolnij_lekarz BEFORE DELETE ON public.lekarz FOR EACH ROW EXECUTE PROCEDURE public.usun_lekarz();


--
-- TOC entry 4072 (class 2606 OID 3232805)
-- Name: pacjent adres_pacjent_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.pacjent
    ADD CONSTRAINT adres_pacjent_fk FOREIGN KEY (id_adres) REFERENCES public.adres(id_adres);


--
-- TOC entry 4071 (class 2606 OID 3232810)
-- Name: placowka adres_placowka_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.placowka
    ADD CONSTRAINT adres_placowka_fk FOREIGN KEY (id_adres) REFERENCES public.adres(id_adres);


--
-- TOC entry 4073 (class 2606 OID 3232830)
-- Name: pacjent_dolegliwosc dolegliwosc_pacjent_dolegliwosc_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.pacjent_dolegliwosc
    ADD CONSTRAINT dolegliwosc_pacjent_dolegliwosc_fk FOREIGN KEY (id_dolegliwosc) REFERENCES public.dolegliwosc(id_dolegliwosc);


--
-- TOC entry 4089 (class 2606 OID 3232895)
-- Name: wizyta dyzur_wizyta_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.wizyta
    ADD CONSTRAINT dyzur_wizyta_fk FOREIGN KEY (id_dyzur) REFERENCES public.dyzur(id_dyzur);


--
-- TOC entry 4080 (class 2606 OID 3232875)
-- Name: e_recepta_lek e_recepta_e_recepta_lek_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.e_recepta_lek
    ADD CONSTRAINT e_recepta_e_recepta_lek_fk FOREIGN KEY (id_e_recepta) REFERENCES public.e_recepta(id_e_recepta);


--
-- TOC entry 4087 (class 2606 OID 3232890)
-- Name: dyzur gabinet_dyzur_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.dyzur
    ADD CONSTRAINT gabinet_dyzur_fk FOREIGN KEY (id_gabinet) REFERENCES public.gabinet(id_gabinet);


--
-- TOC entry 4079 (class 2606 OID 3232825)
-- Name: e_recepta_lek lek_e_recepta_lek_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.e_recepta_lek
    ADD CONSTRAINT lek_e_recepta_lek_fk FOREIGN KEY (id_lek) REFERENCES public.lek(id_lek);


--
-- TOC entry 4086 (class 2606 OID 3232855)
-- Name: dyzur lekarz_dyzur_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.dyzur
    ADD CONSTRAINT lekarz_dyzur_fk FOREIGN KEY (id_lekarz) REFERENCES public.lekarz(id_lekarz);


--
-- TOC entry 4078 (class 2606 OID 3232865)
-- Name: e_recepta lekarz_e_recepta_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.e_recepta
    ADD CONSTRAINT lekarz_e_recepta_fk FOREIGN KEY (id_lekarz) REFERENCES public.lekarz(id_lekarz);


--
-- TOC entry 4083 (class 2606 OID 3232860)
-- Name: lekarz_poradnia lekarz_lekarz_poradnia_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.lekarz_poradnia
    ADD CONSTRAINT lekarz_lekarz_poradnia_fk FOREIGN KEY (id_lekarz) REFERENCES public.lekarz(id_lekarz);


--
-- TOC entry 4076 (class 2606 OID 3232870)
-- Name: lekarz_specjalizacja lekarz_lekarz_specjalizacja_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.lekarz_specjalizacja
    ADD CONSTRAINT lekarz_lekarz_specjalizacja_fk FOREIGN KEY (id_lekarz) REFERENCES public.lekarz(id_lekarz);


--
-- TOC entry 4077 (class 2606 OID 3232850)
-- Name: e_recepta pacjent_e_recepta_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.e_recepta
    ADD CONSTRAINT pacjent_e_recepta_fk FOREIGN KEY (id_pacjent) REFERENCES public.pacjent(id_pacjent);


--
-- TOC entry 4074 (class 2606 OID 3232845)
-- Name: pacjent_dolegliwosc pacjent_pacjent_dolegliwosc_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.pacjent_dolegliwosc
    ADD CONSTRAINT pacjent_pacjent_dolegliwosc_fk FOREIGN KEY (id_pacjent) REFERENCES public.pacjent(id_pacjent);


--
-- TOC entry 4088 (class 2606 OID 3232840)
-- Name: wizyta pacjent_wizyta_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.wizyta
    ADD CONSTRAINT pacjent_wizyta_fk FOREIGN KEY (id_pacjent) REFERENCES public.pacjent(id_pacjent);


--
-- TOC entry 4082 (class 2606 OID 3232820)
-- Name: poradnia placowka_poradnia_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.poradnia
    ADD CONSTRAINT placowka_poradnia_fk FOREIGN KEY (id_placowka) REFERENCES public.placowka(id_placowka);


--
-- TOC entry 4085 (class 2606 OID 3232880)
-- Name: gabinet poradnia_gabinet_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.gabinet
    ADD CONSTRAINT poradnia_gabinet_fk FOREIGN KEY (id_poradnia) REFERENCES public.poradnia(id_poradnia);


--
-- TOC entry 4084 (class 2606 OID 3232885)
-- Name: lekarz_poradnia poradnia_lekarz_poradnia_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.lekarz_poradnia
    ADD CONSTRAINT poradnia_lekarz_poradnia_fk FOREIGN KEY (id_poradnia) REFERENCES public.poradnia(id_poradnia);


--
-- TOC entry 4081 (class 2606 OID 3232815)
-- Name: poradnia poradnia_typ_poradnia_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.poradnia
    ADD CONSTRAINT poradnia_typ_poradnia_fk FOREIGN KEY (id_typ) REFERENCES public.poradnia_typ(id_typ);


--
-- TOC entry 4075 (class 2606 OID 3232835)
-- Name: lekarz_specjalizacja specjalizacja_lekarz_specjalizacja_fk; Type: FK CONSTRAINT; Schema: public; Owner: cjsniglj
--

ALTER TABLE ONLY public.lekarz_specjalizacja
    ADD CONSTRAINT specjalizacja_lekarz_specjalizacja_fk FOREIGN KEY (id_specjalizacja) REFERENCES public.specjalizacja(id_specjalizacja);


-- Completed on 2021-02-05 14:38:21

--
-- PostgreSQL database dump complete
--

