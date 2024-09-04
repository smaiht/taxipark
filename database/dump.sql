--
-- PostgreSQL database dump
--

-- Dumped from database version 16.4 (Ubuntu 16.4-0ubuntu0.24.04.2)
-- Dumped by pg_dump version 16.4 (Ubuntu 16.4-0ubuntu0.24.04.2)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: notify_messenger_messages(); Type: FUNCTION; Schema: public; Owner: root
--

CREATE FUNCTION public.notify_messenger_messages() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
            BEGIN
                PERFORM pg_notify('messenger_messages', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$;


ALTER FUNCTION public.notify_messenger_messages() OWNER TO root;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: car; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.car (
    id integer NOT NULL,
    license_plate character varying(32) NOT NULL,
    brand character varying(32) NOT NULL,
    model character varying(255) NOT NULL
);


ALTER TABLE public.car OWNER TO root;

--
-- Name: car_change_log; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.car_change_log (
    id integer NOT NULL,
    old_car_id integer,
    new_car_id integer,
    driver_id integer NOT NULL,
    change_date timestamp(0) without time zone NOT NULL
);


ALTER TABLE public.car_change_log OWNER TO root;

--
-- Name: car_change_log_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.car_change_log_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.car_change_log_id_seq OWNER TO root;

--
-- Name: car_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.car_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.car_id_seq OWNER TO root;

--
-- Name: doctrine_migration_versions; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.doctrine_migration_versions (
    version character varying(191) NOT NULL,
    executed_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    execution_time integer
);


ALTER TABLE public.doctrine_migration_versions OWNER TO root;

--
-- Name: driver; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.driver (
    id integer NOT NULL,
    car_id integer,
    name character varying(255) NOT NULL,
    birthday date NOT NULL
);


ALTER TABLE public.driver OWNER TO root;

--
-- Name: driver_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.driver_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.driver_id_seq OWNER TO root;

--
-- Name: messenger_messages; Type: TABLE; Schema: public; Owner: root
--

CREATE TABLE public.messenger_messages (
    id bigint NOT NULL,
    body text NOT NULL,
    headers text NOT NULL,
    queue_name character varying(190) NOT NULL,
    created_at timestamp(0) without time zone NOT NULL,
    available_at timestamp(0) without time zone NOT NULL,
    delivered_at timestamp(0) without time zone DEFAULT NULL::timestamp without time zone
);


ALTER TABLE public.messenger_messages OWNER TO root;

--
-- Name: COLUMN messenger_messages.created_at; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON COLUMN public.messenger_messages.created_at IS '(DC2Type:datetime_immutable)';


--
-- Name: COLUMN messenger_messages.available_at; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON COLUMN public.messenger_messages.available_at IS '(DC2Type:datetime_immutable)';


--
-- Name: COLUMN messenger_messages.delivered_at; Type: COMMENT; Schema: public; Owner: root
--

COMMENT ON COLUMN public.messenger_messages.delivered_at IS '(DC2Type:datetime_immutable)';


--
-- Name: messenger_messages_id_seq; Type: SEQUENCE; Schema: public; Owner: root
--

CREATE SEQUENCE public.messenger_messages_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.messenger_messages_id_seq OWNER TO root;

--
-- Name: messenger_messages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: root
--

ALTER SEQUENCE public.messenger_messages_id_seq OWNED BY public.messenger_messages.id;


--
-- Name: messenger_messages id; Type: DEFAULT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.messenger_messages ALTER COLUMN id SET DEFAULT nextval('public.messenger_messages_id_seq'::regclass);


--
-- Data for Name: car; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.car (id, license_plate, brand, model) FROM stdin;
43	С805ТК52	Nissan	molestiae
44	В404МХ3	Ford	qui
46	Р521КН122	Toyota	in
47	К228МВ135	Nissan	nihil
48	О957АН172	Nissan	et
49	Е252РТ7	Лада	accusamus
50	А223МУ170	Honda	nihil
51	Е767ВС178	Audi	est
52	Т241ТМ57	Nissan	omnis
53	С588МТ106	Volkswagen	itaque
54	М486ХА168	BMW	ex
55	О179СЕ137	Ford	voluptas
56	У790ОН193	Volkswagen	distinctio
57	М835СА27	ГАЗ	quia
58	У873ОО175	Лада	id
59	Р374СМ169	Honda	esse
60	С426КВ57	Volkswagen	natus
41	С958ОУ88fdsfdsfsdf	Forddsfdsfdsf	Eum123213123
61	1337	feeef4324	123
62	666	666	666
45	Е718АХ171	Ford	Ducimus
42	В231АН45	Mercedes1111	Aliquam
\.


--
-- Data for Name: car_change_log; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.car_change_log (id, old_car_id, new_car_id, driver_id, change_date) FROM stdin;
1	45	\N	55	2024-09-04 13:24:21
2	\N	44	55	2024-09-04 13:24:31
3	\N	44	74	2024-09-04 14:40:40
\.


--
-- Data for Name: doctrine_migration_versions; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.doctrine_migration_versions (version, executed_at, execution_time) FROM stdin;
DoctrineMigrations\\Version20240903133210	2024-09-03 21:32:39	48
DoctrineMigrations\\Version20240903133942	2024-09-03 21:39:57	3
DoctrineMigrations\\Version20240904052323	2024-09-04 13:23:43	39
\.


--
-- Data for Name: driver; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.driver (id, car_id, name, birthday) FROM stdin;
56	53	Андрей Романович Лобанов	1966-09-02
57	52	Эмилия Фёдоровна Афанасьева	1994-08-14
59	54	Шаров Кузьма Алексеевич	1994-05-19
60	44	Кузнецова Маргарита Александровна	1968-11-01
62	43	Нина Сергеевна Наумова	1973-02-17
63	46	Кулагин Пётр Дмитриевич	1965-05-04
64	60	Анастасия Андреевна Зайцева	1973-12-24
65	59	Попова Лилия Александровна	1988-04-14
66	48	Руслан Андреевич Ильин	1986-05-02
67	55	Алексеева Дарья Александровна	1965-11-24
68	43	Маслов Тарас Евгеньевич	1978-10-06
52	41	Александр Фёдорович Одинцов2	1979-02-28
51	\N	Иннокентий Евгеньевич Казаков11	1997-10-28
71	41	1111	2024-09-05
72	43	222	2024-09-07
53	\N	Логинов Егор Фёдорович	1995-12-04
61	\N	Субботина Дарья Максимовна	1981-05-16
69	\N	Анжелика Андреевна Васильева	2003-12-21
73	\N	кек	2023-06-27
70	\N	Любовь Андреевна Жданова	2005-07-21
54	62	Артём Сергеевич Селиверстов	1971-04-18
55	44	Нестор Романович Родионов	1975-11-04
58	45	Пётр Романович Якушев	2002-04-09
74	44	test	2024-09-12
\.


--
-- Data for Name: messenger_messages; Type: TABLE DATA; Schema: public; Owner: root
--

COPY public.messenger_messages (id, body, headers, queue_name, created_at, available_at, delivered_at) FROM stdin;
\.


--
-- Name: car_change_log_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.car_change_log_id_seq', 3, true);


--
-- Name: car_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.car_id_seq', 62, true);


--
-- Name: driver_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.driver_id_seq', 74, true);


--
-- Name: messenger_messages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: root
--

SELECT pg_catalog.setval('public.messenger_messages_id_seq', 1, false);


--
-- Name: car_change_log car_change_log_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.car_change_log
    ADD CONSTRAINT car_change_log_pkey PRIMARY KEY (id);


--
-- Name: car car_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.car
    ADD CONSTRAINT car_pkey PRIMARY KEY (id);


--
-- Name: doctrine_migration_versions doctrine_migration_versions_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.doctrine_migration_versions
    ADD CONSTRAINT doctrine_migration_versions_pkey PRIMARY KEY (version);


--
-- Name: driver driver_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.driver
    ADD CONSTRAINT driver_pkey PRIMARY KEY (id);


--
-- Name: messenger_messages messenger_messages_pkey; Type: CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.messenger_messages
    ADD CONSTRAINT messenger_messages_pkey PRIMARY KEY (id);


--
-- Name: idx_11667cd9c3c6f69f; Type: INDEX; Schema: public; Owner: root
--

CREATE INDEX idx_11667cd9c3c6f69f ON public.driver USING btree (car_id);


--
-- Name: idx_6cc584c93b5cceb5; Type: INDEX; Schema: public; Owner: root
--

CREATE INDEX idx_6cc584c93b5cceb5 ON public.car_change_log USING btree (new_car_id);


--
-- Name: idx_6cc584c98a092518; Type: INDEX; Schema: public; Owner: root
--

CREATE INDEX idx_6cc584c98a092518 ON public.car_change_log USING btree (old_car_id);


--
-- Name: idx_6cc584c9c3423909; Type: INDEX; Schema: public; Owner: root
--

CREATE INDEX idx_6cc584c9c3423909 ON public.car_change_log USING btree (driver_id);


--
-- Name: idx_75ea56e016ba31db; Type: INDEX; Schema: public; Owner: root
--

CREATE INDEX idx_75ea56e016ba31db ON public.messenger_messages USING btree (delivered_at);


--
-- Name: idx_75ea56e0e3bd61ce; Type: INDEX; Schema: public; Owner: root
--

CREATE INDEX idx_75ea56e0e3bd61ce ON public.messenger_messages USING btree (available_at);


--
-- Name: idx_75ea56e0fb7336f0; Type: INDEX; Schema: public; Owner: root
--

CREATE INDEX idx_75ea56e0fb7336f0 ON public.messenger_messages USING btree (queue_name);


--
-- Name: messenger_messages notify_trigger; Type: TRIGGER; Schema: public; Owner: root
--

CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON public.messenger_messages FOR EACH ROW EXECUTE FUNCTION public.notify_messenger_messages();


--
-- Name: driver fk_11667cd9c3c6f69f; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.driver
    ADD CONSTRAINT fk_11667cd9c3c6f69f FOREIGN KEY (car_id) REFERENCES public.car(id);


--
-- Name: car_change_log fk_6cc584c93b5cceb5; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.car_change_log
    ADD CONSTRAINT fk_6cc584c93b5cceb5 FOREIGN KEY (new_car_id) REFERENCES public.car(id);


--
-- Name: car_change_log fk_6cc584c98a092518; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.car_change_log
    ADD CONSTRAINT fk_6cc584c98a092518 FOREIGN KEY (old_car_id) REFERENCES public.car(id);


--
-- Name: car_change_log fk_6cc584c9c3423909; Type: FK CONSTRAINT; Schema: public; Owner: root
--

ALTER TABLE ONLY public.car_change_log
    ADD CONSTRAINT fk_6cc584c9c3423909 FOREIGN KEY (driver_id) REFERENCES public.driver(id);


--
-- PostgreSQL database dump complete
--

