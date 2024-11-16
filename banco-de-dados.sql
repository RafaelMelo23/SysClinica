CREATE TABLE IF NOT EXISTS `medico` (
	`id_medico` int AUTO_INCREMENT NOT NULL UNIQUE,
	`nome_medico` varchar(100),
	`crm_medico` varchar(20),
	`especialidade_medico` varchar(40),
	PRIMARY KEY (`id_medico`)
);

CREATE TABLE IF NOT EXISTS `paciente` (
	`id_paciente` int AUTO_INCREMENT NOT NULL UNIQUE,
	`nome_paciente` varchar(100),
	`cpf_paciente` varchar(14),
	`dt_nasc_paciente` date,
	`sexo_paciente` binary(1),
	`endereco_paciente` varchar(100),
	`fone_paciente` varchar(20),
	`email_paciente` varchar(100),
	PRIMARY KEY (`id_paciente`)
);

CREATE TABLE IF NOT EXISTS `consulta` (
	`id_consulta` int AUTO_INCREMENT NOT NULL UNIQUE,
	`data_consulta` date,
	`hora_consulta` time,
	`descricao_consulta` text,
	`medico_id_medico` int NOT NULL UNIQUE,
	`paciente_id_paciente` int NOT NULL UNIQUE,
	PRIMARY KEY (`id_consulta`)
);



ALTER TABLE `consulta` ADD CONSTRAINT `consulta_fk4` FOREIGN KEY (`medico_id_medico`) REFERENCES `medico`(`id_medico`);

ALTER TABLE `consulta` ADD CONSTRAINT `consulta_fk5` FOREIGN KEY (`paciente_id_paciente`) REFERENCES `paciente`(`id_paciente`);