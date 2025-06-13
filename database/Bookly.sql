--
-- PostgreSQL database dump
--

-- Dumped from database version 17.4 (Debian 17.4-1.pgdg120+2)
-- Dumped by pg_dump version 17.4

-- Started on 2025-06-13 11:51:19 UTC

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 863 (class 1247 OID 16400)
-- Name: user_role; Type: TYPE; Schema: public; Owner: docker
--

CREATE TYPE public.user_role AS ENUM (
    'USER',
    'ADMIN'
);


ALTER TYPE public.user_role OWNER TO docker;

--
-- TOC entry 231 (class 1255 OID 16416)
-- Name: generate_unique_code(); Type: FUNCTION; Schema: public; Owner: docker
--

CREATE FUNCTION public.generate_unique_code() RETURNS character
    LANGUAGE plpgsql
    AS $$
DECLARE
    new_code CHAR(6);
BEGIN
    LOOP
        new_code := LPAD((FLOOR(RANDOM() * 1000000))::TEXT, 6, '0');

        EXIT WHEN NOT EXISTS (
            SELECT 1 FROM registration_codes WHERE code = new_code
        );
    END LOOP;

    RETURN new_code;
END;
$$;


ALTER FUNCTION public.generate_unique_code() OWNER TO docker;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 228 (class 1259 OID 16452)
-- Name: book_stock; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.book_stock (
    id integer NOT NULL,
    book_id integer NOT NULL,
    library_id integer NOT NULL,
    quantity integer NOT NULL,
    CONSTRAINT book_stock_quantity_check CHECK ((quantity >= 0))
);


ALTER TABLE public.book_stock OWNER TO docker;

--
-- TOC entry 227 (class 1259 OID 16451)
-- Name: book_stock_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.book_stock_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.book_stock_id_seq OWNER TO docker;

--
-- TOC entry 3450 (class 0 OID 0)
-- Dependencies: 227
-- Name: book_stock_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.book_stock_id_seq OWNED BY public.book_stock.id;


--
-- TOC entry 226 (class 1259 OID 16438)
-- Name: books; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.books (
    id integer NOT NULL,
    title text NOT NULL,
    author text NOT NULL,
    category_id integer NOT NULL
);


ALTER TABLE public.books OWNER TO docker;

--
-- TOC entry 225 (class 1259 OID 16437)
-- Name: books_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.books_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.books_id_seq OWNER TO docker;

--
-- TOC entry 3451 (class 0 OID 0)
-- Dependencies: 225
-- Name: books_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.books_id_seq OWNED BY public.books.id;


--
-- TOC entry 224 (class 1259 OID 16427)
-- Name: categories; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.categories (
    id integer NOT NULL,
    name text NOT NULL,
    icon character varying(100)
);


ALTER TABLE public.categories OWNER TO docker;

--
-- TOC entry 223 (class 1259 OID 16426)
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.categories_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categories_id_seq OWNER TO docker;

--
-- TOC entry 3452 (class 0 OID 0)
-- Dependencies: 223
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- TOC entry 222 (class 1259 OID 16418)
-- Name: libraries; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.libraries (
    id integer NOT NULL,
    name text NOT NULL,
    address text NOT NULL
);


ALTER TABLE public.libraries OWNER TO docker;

--
-- TOC entry 221 (class 1259 OID 16417)
-- Name: libraries_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.libraries_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.libraries_id_seq OWNER TO docker;

--
-- TOC entry 3453 (class 0 OID 0)
-- Dependencies: 221
-- Name: libraries_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.libraries_id_seq OWNED BY public.libraries.id;


--
-- TOC entry 220 (class 1259 OID 16407)
-- Name: registration_codes; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.registration_codes (
    id integer NOT NULL,
    code character(6) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);


ALTER TABLE public.registration_codes OWNER TO docker;

--
-- TOC entry 219 (class 1259 OID 16406)
-- Name: registration_codes_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.registration_codes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.registration_codes_id_seq OWNER TO docker;

--
-- TOC entry 3454 (class 0 OID 0)
-- Dependencies: 219
-- Name: registration_codes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.registration_codes_id_seq OWNED BY public.registration_codes.id;


--
-- TOC entry 230 (class 1259 OID 16472)
-- Name: reservations; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.reservations (
    id integer NOT NULL,
    user_id integer NOT NULL,
    book_id integer NOT NULL,
    library_id integer NOT NULL,
    reservation_code character(8) NOT NULL,
    reserved_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    status text DEFAULT 'ACTIVE'::text,
    CONSTRAINT reservations_status_check CHECK ((status = ANY (ARRAY['ACTIVE'::text, 'COLLECTED'::text, 'CANCELLED'::text])))
);


ALTER TABLE public.reservations OWNER TO docker;

--
-- TOC entry 229 (class 1259 OID 16471)
-- Name: reservations_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public.reservations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.reservations_id_seq OWNER TO docker;

--
-- TOC entry 3455 (class 0 OID 0)
-- Dependencies: 229
-- Name: reservations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public.reservations_id_seq OWNED BY public.reservations.id;


--
-- TOC entry 218 (class 1259 OID 16390)
-- Name: users; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public.users (
    id integer NOT NULL,
    email text NOT NULL,
    password text NOT NULL,
    role public.user_role DEFAULT 'USER'::public.user_role NOT NULL
);


ALTER TABLE public.users OWNER TO docker;

--
-- TOC entry 217 (class 1259 OID 16389)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

ALTER TABLE public.users ALTER COLUMN id ADD GENERATED BY DEFAULT AS IDENTITY (
    SEQUENCE NAME public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 3250 (class 2604 OID 16455)
-- Name: book_stock id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.book_stock ALTER COLUMN id SET DEFAULT nextval('public.book_stock_id_seq'::regclass);


--
-- TOC entry 3249 (class 2604 OID 16441)
-- Name: books id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.books ALTER COLUMN id SET DEFAULT nextval('public.books_id_seq'::regclass);


--
-- TOC entry 3248 (class 2604 OID 16430)
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- TOC entry 3247 (class 2604 OID 16421)
-- Name: libraries id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.libraries ALTER COLUMN id SET DEFAULT nextval('public.libraries_id_seq'::regclass);


--
-- TOC entry 3245 (class 2604 OID 16410)
-- Name: registration_codes id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.registration_codes ALTER COLUMN id SET DEFAULT nextval('public.registration_codes_id_seq'::regclass);


--
-- TOC entry 3251 (class 2604 OID 16475)
-- Name: reservations id; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reservations ALTER COLUMN id SET DEFAULT nextval('public.reservations_id_seq'::regclass);


--
-- TOC entry 3442 (class 0 OID 16452)
-- Dependencies: 228
-- Data for Name: book_stock; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.book_stock (id, book_id, library_id, quantity) FROM stdin;
1	1	2	3
2	1	8	4
3	1	4	2
4	2	8	3
5	2	2	6
6	2	7	5
7	3	4	1
8	3	7	7
9	3	5	4
10	4	8	7
11	4	3	4
12	4	4	6
13	4	6	9
14	5	6	6
15	5	10	10
16	6	2	8
17	6	9	5
18	6	5	6
19	6	10	9
20	7	1	3
21	7	2	9
22	7	5	7
24	8	5	7
25	9	5	9
27	9	8	8
28	10	7	6
29	10	5	2
30	11	3	7
31	11	10	1
32	11	5	7
33	11	7	2
34	12	3	2
35	12	9	3
36	13	4	10
37	13	7	5
38	13	5	10
39	14	6	5
40	14	5	1
41	14	4	5
43	15	3	6
44	16	10	7
45	16	6	2
46	17	7	7
47	17	3	7
48	17	9	10
49	18	2	1
50	18	1	1
51	18	6	9
52	18	8	7
53	19	4	3
54	19	7	1
55	20	4	6
56	20	5	10
57	20	1	7
58	20	7	4
59	21	4	7
60	21	1	8
61	21	2	9
62	21	7	5
63	22	4	9
64	22	6	10
65	22	5	10
66	23	2	5
67	23	7	5
68	23	10	7
69	23	8	3
70	24	9	10
71	24	7	2
72	24	5	8
73	25	8	3
74	25	7	4
75	25	5	4
76	26	10	1
77	26	7	2
78	27	5	6
79	27	10	3
80	27	2	6
81	27	8	5
82	28	3	9
83	28	6	10
84	29	8	1
85	29	6	8
86	29	9	4
87	29	4	2
88	30	4	2
89	30	2	10
90	30	10	7
91	31	1	15
92	31	2	10
23	8	3	0
26	9	4	8
42	15	2	9
\.


--
-- TOC entry 3440 (class 0 OID 16438)
-- Dependencies: 226
-- Data for Name: books; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.books (id, title, author, category_id) FROM stdin;
1	Zbrodnia i kara	Fiodor Dostojewski	1
2	Władca Pierścieni	J.R.R. Tolkien	2
3	Harry Potter i Kamień Filozoficzny	J.K. Rowling	2
4	Sherlock Holmes	Arthur Conan Doyle	3
5	Krótka historia czasu	Stephen Hawking	4
6	Steve Jobs	Walter Isaacson	5
7	Potęga podświadomości	Joseph Murphy	6
8	Bogaty ojciec, biedny ojciec	Robert Kiyosaki	7
9	Sapiens	Yuval Noah Harari	8
10	Świat Zofii	Jostein Gaarder	9
11	Programowanie w C++	Bjarne Stroustrup	10
12	Myśl i bogać się	Napoleon Hill	7
13	Cień wiatru	Carlos Ruiz Zafón	1
14	Hobbit	J.R.R. Tolkien	2
15	1984	George Orwell	2
16	Zabić drozda	Harper Lee	1
17	Dziewczyna z pociągu	Paula Hawkins	3
18	Czarne echo	Michael Connelly	3
19	Fenomen poranka	Hal Elrod	6
20	Siła nawyku	Charles Duhigg	6
21	Lean Startup	Eric Ries	7
22	Wielki Gatsby	F. Scott Fitzgerald	1
23	Metro 2033	Dmitry Glukhovsky	2
24	Mały Książę	Antoine de Saint-Exupéry	1
25	Zaginiona dziewczyna	Gillian Flynn	3
26	Python. Wprowadzenie	Mark Lutz	10
27	O powstawaniu gatunków	Charles Darwin	4
28	Obłęd	Justyna Kopińska	5
29	Mit przedsiębiorczości	Michael E. Gerber	7
30	Lalka	Bolesław Prus	1
31	Otoczeni przez idiotów	Thomas Erikson	6
\.


--
-- TOC entry 3438 (class 0 OID 16427)
-- Dependencies: 224
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.categories (id, name, icon) FROM stdin;
1	Literatura piękna	fa-pen-nib
2	Fantastyka	fa-hat-wizard
3	Kryminał	fa-user-secret
4	Nauka	fa-flask
5	Biografia	fa-user
6	Psychologia	fa-brain
7	Biznes	fa-briefcase
8	Historia	fa-landmark
9	Filozofia	fa-scale-balanced
10	Technologia	fa-microchip
11	Nowela	fa-envelope
\.


--
-- TOC entry 3436 (class 0 OID 16418)
-- Dependencies: 222
-- Data for Name: libraries; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.libraries (id, name, address) FROM stdin;
1	Politechnika Krakowska	ul. Przykładowa 1
2	Uniwersytet Jagielloński	ul. Przykładowa 1
3	AGH	ul. Przykładowa 1
4	Politechnika Warszawska	ul. Przykładowa 1
5	Uniwersytet Warszawski	ul. Przykładowa 1
6	Politechnika Wrocławska	ul. Przykładowa 1
7	Uniwersytet Wrocławski	ul. Przykładowa 1
8	Politechnika Gdańska	ul. Przykładowa 1
9	Uniwersytet Gdański	ul. Przykładowa 1
10	Uniwersytet im. Adama Mickiewicza	ul. Przykładowa 1
\.


--
-- TOC entry 3434 (class 0 OID 16407)
-- Dependencies: 220
-- Data for Name: registration_codes; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.registration_codes (id, code, created_at) FROM stdin;
2	093662	2025-05-28 18:36:56.109574
3	649517	2025-05-28 18:36:56.109574
4	793943	2025-05-28 18:36:56.109574
8	454155	2025-05-28 18:36:56.109574
11	889197	2025-05-28 18:36:56.109574
12	207182	2025-05-28 18:36:56.109574
13	658933	2025-05-28 18:36:56.109574
14	300313	2025-05-28 18:36:56.109574
15	359250	2025-05-28 18:36:56.109574
16	858599	2025-05-28 18:36:56.109574
17	966784	2025-05-28 18:36:56.109574
18	347875	2025-05-28 18:36:56.109574
19	771769	2025-05-28 18:36:56.109574
20	443083	2025-05-28 18:36:56.109574
21	018183	2025-05-28 18:36:56.109574
22	842819	2025-05-28 18:36:56.109574
23	792895	2025-05-28 18:36:56.109574
24	617087	2025-05-28 18:36:56.109574
25	254843	2025-05-28 18:36:56.109574
26	918774	2025-05-28 18:36:56.109574
27	191509	2025-05-28 18:36:56.109574
28	175239	2025-05-28 18:36:56.109574
29	862029	2025-05-28 18:36:56.109574
30	415238	2025-05-28 18:36:56.109574
31	240248	2025-05-28 18:36:56.109574
32	851976	2025-05-28 18:36:56.109574
33	963775	2025-05-28 18:36:56.109574
34	891062	2025-05-28 18:36:56.109574
35	178594	2025-05-28 18:36:56.109574
36	154400	2025-05-28 18:36:56.109574
37	246047	2025-05-28 18:36:56.109574
38	469541	2025-05-28 18:36:56.109574
39	311942	2025-05-28 18:36:56.109574
40	833069	2025-05-28 18:36:56.109574
41	611580	2025-05-28 18:36:56.109574
42	693237	2025-05-28 18:36:56.109574
43	967393	2025-05-28 18:36:56.109574
44	600068	2025-05-28 18:36:56.109574
45	310005	2025-05-28 18:36:56.109574
46	460490	2025-05-28 18:36:56.109574
47	867085	2025-05-28 18:36:56.109574
48	650803	2025-05-28 18:36:56.109574
49	217110	2025-05-28 18:36:56.109574
50	736596	2025-05-28 18:36:56.109574
51	065394	2025-05-28 18:36:56.109574
52	102381	2025-05-28 18:36:56.109574
53	383714	2025-05-28 18:36:56.109574
54	337178	2025-05-28 18:36:56.109574
55	216853	2025-05-28 18:36:56.109574
56	673642	2025-05-28 18:36:56.109574
57	128923	2025-05-28 18:36:56.109574
58	463430	2025-05-28 18:36:56.109574
59	803115	2025-05-28 18:36:56.109574
60	789205	2025-05-28 18:36:56.109574
61	689767	2025-05-28 18:36:56.109574
62	179212	2025-05-28 18:36:56.109574
63	570890	2025-05-28 18:36:56.109574
64	396389	2025-05-28 18:36:56.109574
65	475547	2025-05-28 18:36:56.109574
66	488884	2025-05-28 18:36:56.109574
67	406358	2025-05-28 18:36:56.109574
68	960100	2025-05-28 18:36:56.109574
69	768297	2025-05-28 18:36:56.109574
70	495683	2025-05-28 18:36:56.109574
71	932552	2025-05-28 18:36:56.109574
72	596466	2025-05-28 18:36:56.109574
73	858711	2025-05-28 18:36:56.109574
74	441262	2025-05-28 18:36:56.109574
75	320871	2025-05-28 18:36:56.109574
76	007577	2025-05-28 18:36:56.109574
77	135337	2025-05-28 18:36:56.109574
78	653257	2025-05-28 18:36:56.109574
79	191573	2025-05-28 18:36:56.109574
80	527032	2025-05-28 18:36:56.109574
81	612842	2025-05-28 18:36:56.109574
82	306306	2025-05-28 18:36:56.109574
83	674543	2025-05-28 18:36:56.109574
84	614859	2025-05-28 18:36:56.109574
85	184382	2025-05-28 18:36:56.109574
86	957064	2025-05-28 18:36:56.109574
87	402240	2025-05-28 18:36:56.109574
88	183251	2025-05-28 18:36:56.109574
89	653742	2025-05-28 18:36:56.109574
90	547882	2025-05-28 18:36:56.109574
91	678446	2025-05-28 18:36:56.109574
92	788893	2025-05-28 18:36:56.109574
93	111677	2025-05-28 18:36:56.109574
94	658930	2025-05-28 18:36:56.109574
95	014541	2025-05-28 18:36:56.109574
96	948101	2025-05-28 18:36:56.109574
97	862864	2025-05-28 18:36:56.109574
98	505014	2025-05-28 18:36:56.109574
99	610653	2025-05-28 18:36:56.109574
100	272977	2025-05-28 18:36:56.109574
101	304038	2025-06-04 14:50:50.53634
102	134574	2025-06-04 14:50:50.553526
103	281333	2025-06-04 14:50:50.569371
104	997704	2025-06-04 14:50:50.585406
105	677227	2025-06-04 14:50:50.600919
106	659622	2025-06-04 14:50:50.616869
107	966407	2025-06-04 14:50:50.631825
108	006962	2025-06-04 14:50:50.64793
109	522503	2025-06-04 14:50:50.664685
110	869798	2025-06-04 14:50:50.680753
111	334972	2025-06-04 14:51:08.504123
112	710173	2025-06-04 14:51:08.520187
113	992537	2025-06-04 14:51:08.535941
114	694655	2025-06-04 14:51:08.552023
115	757903	2025-06-04 14:51:08.568981
116	705798	2025-06-04 14:51:08.585612
117	663801	2025-06-04 14:51:08.601274
118	351127	2025-06-04 14:51:08.617008
119	072507	2025-06-04 14:51:08.633185
120	021368	2025-06-04 14:51:08.6498
121	725957	2025-06-04 14:51:27.182589
122	650443	2025-06-04 14:51:27.206945
123	751000	2025-06-04 14:51:27.222862
124	307769	2025-06-04 14:51:27.238789
125	889929	2025-06-04 14:51:27.255501
126	360070	2025-06-04 14:51:27.271821
127	747010	2025-06-04 14:51:27.287906
128	330875	2025-06-04 14:51:27.303978
129	354289	2025-06-04 14:51:27.320479
130	813171	2025-06-04 14:51:27.33695
\.


--
-- TOC entry 3444 (class 0 OID 16472)
-- Dependencies: 230
-- Data for Name: reservations; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.reservations (id, user_id, book_id, library_id, reservation_code, reserved_at, status) FROM stdin;
13	5	20	7	DZLH6UBJ	2025-04-29 14:52:34	ACTIVE
14	3	17	4	M4S9K2AM	2025-04-20 14:52:34	ACTIVE
15	5	29	8	FXJ7ZZE8	2025-04-17 14:52:34	CANCELLED
16	3	14	9	3BBXD4TU	2025-04-27 14:52:34	ACTIVE
17	1	3	5	8FEABN6F	2025-04-19 14:52:34	COLLECTED
18	5	26	2	MTX367DK	2025-04-18 14:52:34	ACTIVE
19	5	27	3	6CS3F4DG	2025-04-07 14:52:34	ACTIVE
20	3	7	8	DFBMFTPL	2025-05-25 14:52:34	ACTIVE
21	3	13	6	AGZ4AWZV	2025-05-06 14:52:34	CANCELLED
22	1	22	2	CLPV4VLB	2025-04-04 14:52:34	COLLECTED
23	5	25	8	QJQDP8KU	2025-05-05 14:52:34	CANCELLED
24	3	26	7	CA3M24HE	2025-05-03 14:52:34	COLLECTED
25	2	7	6	CCPYAB7H	2025-04-10 14:52:34	COLLECTED
26	3	26	10	4RYJAU5Q	2025-04-18 14:52:34	CANCELLED
27	4	28	9	LZTMXZ4R	2025-04-11 14:52:34	ACTIVE
28	4	1	8	4NKWZE82	2025-06-01 14:52:34	ACTIVE
29	4	2	3	FEL36X6K	2025-04-06 14:52:34	CANCELLED
30	4	22	7	QWT3F32R	2025-05-31 14:52:34	COLLECTED
31	5	29	1	ALG4EQAK	2025-05-14 14:52:34	ACTIVE
32	1	5	4	72RV8Z5B	2025-05-18 14:52:34	COLLECTED
33	3	26	3	NPB3SBHR	2025-05-30 14:52:34	CANCELLED
34	2	5	8	CXC7G5P6	2025-04-06 14:52:34	ACTIVE
35	5	16	10	AG65KV9E	2025-04-21 14:52:34	COLLECTED
36	4	14	4	HC5G9MCZ	2025-04-23 14:52:34	CANCELLED
37	1	27	9	LUGWS8M7	2025-05-28 14:52:34	COLLECTED
38	4	17	10	E7YQA947	2025-05-20 14:52:34	ACTIVE
39	5	13	4	4S2Y3K2E	2025-05-14 14:52:34	ACTIVE
40	2	6	2	CSR9NJMK	2025-05-07 14:52:34	ACTIVE
41	2	18	10	NXYV5N6K	2025-05-22 14:52:34	CANCELLED
42	3	28	1	MW5PY3Y9	2025-04-23 14:52:34	COLLECTED
43	2	10	9	2NTCFHAY	2025-05-06 14:52:34	CANCELLED
44	1	29	10	545WU5B9	2025-04-11 14:52:34	ACTIVE
45	2	28	4	UYEXNMNC	2025-05-27 14:52:34	COLLECTED
46	4	30	9	2BEX32A9	2025-05-23 14:52:34	CANCELLED
47	2	18	7	L2W2WEUF	2025-05-15 14:52:34	ACTIVE
48	1	15	4	BT2TRRHL	2025-04-14 14:52:34	COLLECTED
49	5	2	2	ESAUC7CF	2025-04-20 14:52:34	COLLECTED
50	5	7	4	V46T3XP5	2025-06-01 14:52:34	COLLECTED
51	1	10	1	CXAMF3RA	2025-05-16 14:52:34	COLLECTED
52	2	6	6	UUHKG4V3	2025-05-05 14:52:34	CANCELLED
53	4	6	2	V7GE8ER2	2025-05-14 14:52:34	COLLECTED
54	4	6	5	QMQ7J2TG	2025-05-04 14:52:34	ACTIVE
55	3	11	7	BVDCL6DS	2025-05-16 14:52:34	CANCELLED
56	4	2	1	ZP3U9XM2	2025-06-02 14:52:34	ACTIVE
57	5	5	10	WE3XWM2U	2025-05-07 14:52:34	ACTIVE
58	4	27	8	BDDJCB9S	2025-05-25 14:52:34	ACTIVE
59	5	17	10	T5E82TLH	2025-06-02 14:52:34	CANCELLED
60	5	2	1	S4J3JDZJ	2025-05-02 14:52:34	CANCELLED
61	3	5	9	SK9VLW5M	2025-04-12 14:52:34	CANCELLED
62	4	7	3	N8DYEJLD	2025-04-23 14:52:34	CANCELLED
63	3	8	3	WBUZM6VO	2025-06-09 14:00:20.871435	ACTIVE
64	3	8	3	ZVOB06AH	2025-06-09 14:01:28.756624	ACTIVE
65	3	8	3	CN0U8EH9	2025-06-09 14:01:30.428921	ACTIVE
66	3	8	3	COXMZADG	2025-06-09 14:01:32.468335	ACTIVE
67	3	9	4	IRD4XGAZ	2025-06-09 14:38:15.351289	ACTIVE
68	3	15	2	2901QMEI	2025-06-13 11:47:48.599188	ACTIVE
\.


--
-- TOC entry 3432 (class 0 OID 16390)
-- Dependencies: 218
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public.users (id, email, password, role) FROM stdin;
2	anna@example.com	admin	USER
1	jan@example.com	admin	USER
3	skibidi@sigma.pl	$2y$10$9QwnOfjQVMR32lm/4MYbKOQWknBHrZYa1xyUjplA6bxgyYLiRtjjC	ADMIN
4	filipduchnik@gmail.com	$2y$10$9QwnOfjQVMR32lm/4MYbKOQWknBHrZYa1xyUjplA6bxgyYLiRtjjC	USER
5	filipduchnik@outlook.com	$2y$10$3Cs9Gduoiw/H91fKj9a7oO0SRUlHxZqUsB.S7tImzd220yYNqExhK	USER
\.


--
-- TOC entry 3456 (class 0 OID 0)
-- Dependencies: 227
-- Name: book_stock_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.book_stock_id_seq', 92, true);


--
-- TOC entry 3457 (class 0 OID 0)
-- Dependencies: 225
-- Name: books_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.books_id_seq', 31, true);


--
-- TOC entry 3458 (class 0 OID 0)
-- Dependencies: 223
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.categories_id_seq', 11, true);


--
-- TOC entry 3459 (class 0 OID 0)
-- Dependencies: 221
-- Name: libraries_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.libraries_id_seq', 10, true);


--
-- TOC entry 3460 (class 0 OID 0)
-- Dependencies: 219
-- Name: registration_codes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.registration_codes_id_seq', 130, true);


--
-- TOC entry 3461 (class 0 OID 0)
-- Dependencies: 229
-- Name: reservations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.reservations_id_seq', 68, true);


--
-- TOC entry 3462 (class 0 OID 0)
-- Dependencies: 217
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public.users_id_seq', 10, true);


--
-- TOC entry 3273 (class 2606 OID 16458)
-- Name: book_stock book_stock_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.book_stock
    ADD CONSTRAINT book_stock_pkey PRIMARY KEY (id);


--
-- TOC entry 3271 (class 2606 OID 16445)
-- Name: books books_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.books
    ADD CONSTRAINT books_pkey PRIMARY KEY (id);


--
-- TOC entry 3267 (class 2606 OID 16436)
-- Name: categories categories_name_key; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_name_key UNIQUE (name);


--
-- TOC entry 3269 (class 2606 OID 16434)
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- TOC entry 3257 (class 2606 OID 16398)
-- Name: users email; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT email UNIQUE (email);


--
-- TOC entry 3265 (class 2606 OID 16425)
-- Name: libraries libraries_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.libraries
    ADD CONSTRAINT libraries_pkey PRIMARY KEY (id);


--
-- TOC entry 3261 (class 2606 OID 16415)
-- Name: registration_codes registration_codes_code_key; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.registration_codes
    ADD CONSTRAINT registration_codes_code_key UNIQUE (code);


--
-- TOC entry 3263 (class 2606 OID 16413)
-- Name: registration_codes registration_codes_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.registration_codes
    ADD CONSTRAINT registration_codes_pkey PRIMARY KEY (id);


--
-- TOC entry 3277 (class 2606 OID 16482)
-- Name: reservations reservations_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_pkey PRIMARY KEY (id);


--
-- TOC entry 3279 (class 2606 OID 16484)
-- Name: reservations reservations_reservation_code_key; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_reservation_code_key UNIQUE (reservation_code);


--
-- TOC entry 3275 (class 2606 OID 16460)
-- Name: book_stock uq_book_library; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.book_stock
    ADD CONSTRAINT uq_book_library UNIQUE (book_id, library_id);


--
-- TOC entry 3259 (class 2606 OID 16396)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 3281 (class 2606 OID 16461)
-- Name: book_stock fk_book; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.book_stock
    ADD CONSTRAINT fk_book FOREIGN KEY (book_id) REFERENCES public.books(id) ON DELETE CASCADE;


--
-- TOC entry 3280 (class 2606 OID 16446)
-- Name: books fk_category; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.books
    ADD CONSTRAINT fk_category FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE CASCADE;


--
-- TOC entry 3282 (class 2606 OID 16466)
-- Name: book_stock fk_library; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.book_stock
    ADD CONSTRAINT fk_library FOREIGN KEY (library_id) REFERENCES public.libraries(id) ON DELETE CASCADE;


--
-- TOC entry 3283 (class 2606 OID 16490)
-- Name: reservations fk_res_book; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT fk_res_book FOREIGN KEY (book_id) REFERENCES public.books(id) ON DELETE CASCADE;


--
-- TOC entry 3284 (class 2606 OID 16495)
-- Name: reservations fk_res_library; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT fk_res_library FOREIGN KEY (library_id) REFERENCES public.libraries(id) ON DELETE CASCADE;


--
-- TOC entry 3285 (class 2606 OID 16485)
-- Name: reservations fk_res_user; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT fk_res_user FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


-- Completed on 2025-06-13 11:51:19 UTC

--
-- PostgreSQL database dump complete
--

