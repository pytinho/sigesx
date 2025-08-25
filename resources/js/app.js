import $ from 'jquery'
import 'jquery-mask-plugin'

window.$ = window.jQuery = $

//ID do IBGE
const UF_TO_ID = {
  AC: 12, AL: 27, AM: 13, AP: 16, BA: 29, CE: 23, DF: 53, ES: 32, GO: 52,
  MA: 21, MG: 31, MS: 50, MT: 51, PA: 15, PB: 25, PE: 26, PI: 22, PR: 41,
  RJ: 33, RN: 24, RO: 11, RR: 14, RS: 43, SC: 42, SE: 28, SP: 35, TO: 17
}

const UFS = Object.keys(UF_TO_ID).sort()

// Preenche o select de UF (naturalidade)
function preencherUF() {
  const $uf = $('#uf')
  if (!$uf.length) return
  $uf.empty().append('<option value="">Selecione</option>')
  UFS.forEach(sigla => {
    $uf.append(`<option value="${sigla}">${sigla}</option>`)
  })
  const oldUf = $uf.data('old-uf')
  if (oldUf) $uf.val(oldUf)
}

// Carrega cidades pelo IBGE (naturalidade)
async function carregarCidades(uf) {
  const $cidade = $('#cidade')
  $cidade.prop('disabled', true).empty().append('<option>Carregando...</option>')

  try {
    const idUF = UF_TO_ID[uf]
    if (!idUF) throw new Error('UF inválida')

    const resp = await fetch(`https://servicodados.ibge.gov.br/api/v1/localidades/estados/${idUF}/municipios?orderBy=nome`)
    const cidades = await resp.json()

    $cidade.empty().append('<option value="">Selecione</option>')
    cidades.forEach(c => $cidade.append(`<option value="${c.nome}">${c.nome}</option>`))
    $cidade.prop('disabled', false)

    const oldCidade = $cidade.data('old-cidade')
    if (oldCidade) $cidade.val(oldCidade)
  } catch (e) {
    $cidade.empty().append('<option>Falha ao carregar</option>').prop('disabled', true)
  }
}

// ViaCEP apenas para endereço
async function buscarCEP(cepMasked) {
  const $help = $('#cepHelp')
  const $end  = $('#endereco')

  const cep = (cepMasked || '').replace(/\D/g, '')
  if (cep.length !== 8) {
    $help.text('CEP inválido').css('color', '#b91c1c')
    return
  }

  $help.text('Buscando endereço...').css('color', '#6b7280')
  $end.prop('readonly', true)

  try {
    const resp = await fetch(`https://viacep.com.br/ws/${cep}/json/`)
    const data = await resp.json()

    if (data.erro) {
      $help.text('CEP não encontrado.').css('color', '#b91c1c')
      $end.prop('readonly', false)
      return
    }

    const log = data.logradouro || ''
    const bai = data.bairro || ''

    // Preenche apenas endereço textual
    $end.val([log, bai].filter(Boolean).join(', '))
    $help.text('Endereço preenchido.').css('color', '#065f46')
  } catch (e) {
    $help.text('Falha ao buscar CEP.').css('color', '#b91c1c')
  } finally {
    $end.prop('readonly', false)
  }
}

// Inicialização
$(function(){
  // Máscaras
  $('#cpf').mask('000.000.000-00')
  $('#cep').mask('00000-000', { onComplete: (cep) => buscarCEP(cep) })
  $('#dt_nascimento, #dt_entrada, #dt_saida').mask('00/00/0000')
  $('#contato').mask('(00) 00000-0000')

  // UF/Cidade (naturalidade)
  preencherUF()

  $('#uf').on('change', async function () {
    const uf = $(this).val()
    if (!uf) {
      $('#cidade').empty().append('<option value="">Selecione a UF primeiro</option>').prop('disabled', true)
      return
    }
    await carregarCidades(uf)
  })

  // CEP: busca ao sair do campo
  $('#cep').on('blur', function () { buscarCEP($(this).val()) })

  const oldUf = $('#uf').data('old-uf')
  if (oldUf) carregarCidades(oldUf)
})
