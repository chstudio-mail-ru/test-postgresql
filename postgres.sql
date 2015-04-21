-- Table: data_rows

-- DROP TABLE data_rows;

CREATE TABLE data_rows
(
  id serial NOT NULL,
  department_id integer,
  name text,
  num integer,
  price numeric(10,2),
  sum numeric(10,2),
  comment text,
  deleted boolean DEFAULT false,
  CONSTRAINT data_rows_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE data_rows
  OWNER TO postgres;

-- Table: departments

-- DROP TABLE departments;

CREATE TABLE departments
(
  id serial NOT NULL,
  name text,
  deleted boolean DEFAULT false,
  CONSTRAINT departments_pkey PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);
ALTER TABLE departments
  OWNER TO postgres;
