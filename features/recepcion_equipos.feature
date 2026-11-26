Feature: Validación del código patrimonial en la recepción de equipos (PBI-01)
  Como personal de la OTSI de la Municipalidad Distrital de San Sebastián
  quiero validar el código patrimonial SBN del equipo recibido
  para evitar registrar identificadores incorrectos

  Scenario: Aceptar un código patrimonial SBN válido
    Given un equipo con código patrimonial "123456789012"
    When se valida el código patrimonial
    Then el sistema acepta el código

  Scenario: Rechazar un código patrimonial con letras
    Given un equipo con código patrimonial "PAT-2026-001"
    When se valida el código patrimonial
    Then el sistema rechaza el código

  Scenario: Rechazar un código patrimonial incompleto
    Given un equipo con código patrimonial "123456"
    When se valida el código patrimonial
    Then el sistema rechaza el código

  Scenario: Rechazar un código patrimonial vacío
    Given un equipo con código patrimonial ""
    When se valida el código patrimonial
    Then el sistema rechaza el código
