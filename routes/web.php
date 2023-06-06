<?php

use Illuminate\Support\Facades\Route;

// Main Page Route
Route::get('/', 'DashboardController@dashboardEcommerce')->name('dashboard-ecommerce');
// Realiza a alteração das cores e personalização do layout
Route::post('/update-skin', 'ConfigController@set_skin')->name('update-skin');

// Rotas de autenticação
Route::group(['prefix' => 'login'], function () {
    Route::get('/', 'LoginController@index')->name('login-page');
    Route::post('/', 'LoginController@login')->name('login');

    // RESETA A SENHA
    Route::get('/reset-senha', 'LoginController@reset_senha')->name('form-reset-senha');
    Route::post('/reset-senha', 'LoginController@update_senha')->name('update-senha');


    Route::get('/confirma-email', 'LoginController@confirma_email')->name('login-confirma-email');
    Route::get('/esqueceu-senha', 'LoginController@esqueceu_senha')->name('login-esqueceu-senha');
    Route::post('/esqueceu-senha', 'LoginController@nova_senha')->name('grava-nova-senha');
    Route::get('/sair', 'LoginController@sair')->name('sair');
});

// configurações dos cadastros
Route::group(['prefix' => 'config'], function () {

    // Centro de custo
    Route::get('/centro-custo', 'CentroCustoController@index')->name('centro-custo')->middleware('permission:ler configuracoes');
    Route::post('/centro-custo/{id?}', 'CentroCustoController@save')->name('centro-custo-save')->middleware('permission:criar profissionais|editar configuracoes');
    Route::get('/centro-custo/ativa_desativa/{id}', 'CentroCustoController@ativa_desativa')->name('centro-custo-ativa_desativa')->middleware('permission:deletar configuracoes');

    // Fundações
    Route::get('/fundacao', 'FundacaoController@index')->name('fundacao')->middleware('permission:ler configuracoes');
    Route::post('/fundacao/{id?}', 'FundacaoController@save')->name('fundacao-save')->middleware('permission:criar profissionais|editar configuracoes');
    Route::get('/fundacao/ativa_desativa/{id}', 'FundacaoController@ativa_desativa')->name('fundacao-ativa_desativa')->middleware('permission:deletar configuracoes');

    // Tipo de Projetos
    Route::get('/tipo-projeto', 'TipoProjetoController@index')->name('tipo-projeto')->middleware('permission:ler configuracoes');
    Route::post('/tipo-projeto/{id?}', 'TipoProjetoController@save')->name('tipo-projeto-save')->middleware('permission:criar profissionais|editar configuracoes');
    Route::get('/tipo-projeto/ativa_desativa/{id}', 'TipoProjetoController@ativa_desativa')->name('tipo-projeto-ativa_desativa')->middleware('permission:deletar configuracoes');
});



// Minha Conta
Route::group(['prefix' => 'minha-conta'], function () {
    Route::get('/', 'MinhaContaController@index')->name('minha-conta');
    Route::get('/senha', 'MinhaContaController@senha')->name('minha-senha');
    Route::post('/senha', 'MinhaContaController@troca_senha')->name('troca-senha');

    Route::post('/update', 'MinhaContaController@update')->name('minha-conta-update');
});

//Usuários e Permissões
Route::group(['prefix' => 'users'], function () {
    Route::get('/', 'UserController@index')->name('users')->middleware('permission:ler usuarios');
    Route::get('/novo', 'UserController@novo')->name('user-novo')->middleware('permission:criar usuarios');
    Route::post('/create', 'UserController@create')->name('user-create')->middleware('permission:criar usuarios');

    Route::get('/show/{id}', 'UserController@show')->name('user-show')->middleware('permission:editar usuarios');
    Route::post('/edit/{id}', 'UserController@edit')->name('user-edit')->middleware('permission:editar usuarios');
    Route::get('/show/permissoes/{id}', 'UserController@show_permissoes')->name('permissoes-show')->middleware('permission:ler permissoes');
    Route::post('/edit/permissoes/{id}', 'UserController@update_permissao')->name('permissoes-edit')->middleware('permission:editar permissoes');

    Route::post('/toogleStatus/{id}', 'UserController@tootle_status')->name('toogle-status')->middleware('permission:deletar usuarios');

    Route::get('/getUsers', 'UserController@getUsers')->name('getUsers')->middleware('permission:ler usuarios');

    Route::get('/permissoes', 'PermissoesController@index')->name('permissoes')->middleware('permission:ler permissoes');
    Route::get('/permissoes/delete/{id}', 'PermissoesController@delete')->name('permissoes-delete')->middleware('permission:deletar permissoes');
    Route::get('/permissoes/list', 'PermissoesController@getListPermissoes')->name('getListPermissoes')->middleware('permission:ler permissoes');
    Route::post('/permissoes/nova', 'PermissoesController@nova')->name('permissoes-novo')->middleware('permission:criar permissoes');


    Route::get('/niveis', 'NiveisController@index')->name('niveis')->middleware('permission:ler niveis');
    Route::get('/niveis/novo', 'NiveisController@novo')->name('niveis-novo')->middleware('permission:criar niveis');
    Route::post('/niveis/novo', 'NiveisController@create')->name('niveis-novopost')->middleware('permission:criar niveis');

    Route::get('/niveis/editar/{id}', 'NiveisController@editar')->name('niveis-editar')->middleware('permission:editar niveis');
    Route::post('/niveis/editar/{id}', 'NiveisController@update')->name('niveis-editarpost')->middleware('permission:editar niveis');
});

// cadastro de profissionais
Route::group(['prefix' => 'profissionais'], function () {
    Route::get('/', 'ProfissionalController@index')->name('pro-list')->middleware('permission:ler profissionais');
    Route::post('/save/{id?}', 'ProfissionalController@save')->name('pro-save')->middleware('permission:criar profissionais|editar profissionais');
    Route::get('/ativa_desativa/{id}', 'ProfissionalController@ativa_desativa')->name('pro-ativa_desativa')->middleware('permission:deletar profissionais');
});

// cadastro de clientes
Route::group(['prefix' => 'clientes'], function () {
    Route::get('/', 'ClienteController@index')->name('cliente-list')->middleware('permission:ler clientes');
    Route::post('/save/{id?}', 'ClienteController@save')->name('cliente-save')->middleware('permission:criar clientes|editar clientes');
    Route::get('/ativa_desativa/{id}', 'ClienteController@ativa_desativa')->name('cliente-ativa_desativa')->middleware('permission:deletar clientes');
});

// cadastro de Ativos
Route::group(['prefix' => 'ativos'], function () {
    Route::get('/', 'AtivoController@index')->name('ativos-list')->middleware('permission:ler ativos');
    Route::post('/save/{id?}', 'AtivoController@save')->name('ativos-save')->middleware('permission:criar ativos|editar ativos');
    Route::get('/ativa_desativa/{id}', 'AtivoController@ativa_desativa')->name('ativos-ativa_desativa')->middleware('permission:deletar ativos');
});

// Lançamentos de Custo de Energia
Route::group(['prefix' => 'custo-energia'], function () {
    Route::get('/', 'EnergiaController@index')->name('energia-list')->middleware('permission:ler energia');
    Route::post('/save/{id?}', 'EnergiaController@save')->name('energia-save')->middleware('permission:criar energia|editar energia');
});

// Materiais de uso e consumo
Route::group(['prefix' => 'materiais'], function () {
    Route::get('/', 'MateriaisController@index')->name('materiais-list')->middleware('permission:ler materiais');
    Route::post('/save/{id?}', 'MateriaisController@save')->name('materiais-save')->middleware('permission:criar materiais|editar materiais');
    Route::get('/ativa_desativa/{id}', 'MateriaisController@ativa_desativa')->name('materiais-ativa_desativa')->middleware('permission:deletar materiais');
});

// Materiais de uso e consumo
Route::group(['prefix' => 'custo-operacional'], function () {
    Route::get('/', 'CustoOperacionalController@index')->name('custo-operacional-list')->middleware('permission:ler custos operacionais');
    Route::post('/save/{id?}', 'CustoOperacionalController@save')->name('custo-operacional-save')->middleware('permission:criar custos operacionais|editar custos operacionais');
    Route::get('/ativa_desativa/{id}', 'CustoOperacionalController@ativa_desativa')->name('custo-operacional-ativa_desativa')->middleware('permission:deletar custos operacionais');
});

Route::group(['prefix' => 'custo-condominio'], function () {
    Route::get('/', 'CustoCondominioController@index')->name('custo-condominio-list')->middleware('permission:ler custos condominios');
    Route::post('/save/{id?}', 'CustoCondominioController@save')->name('custo-condominio-save')->middleware('permission:criar custos condominios|editar custos condominios');
    Route::get('/ativa_desativa/{id}', 'CustoCondominioController@ativa_desativa')->name('custo-condominio-ativa_desativa')->middleware('permission:deletar custos condominios');
});

Route::group(['prefix' => 'entregavel'], function () {
    Route::get('/', 'EntregaveisController@index')->name('entregavel-list')->middleware('permission:ler entregaveis');
    Route::post('/save/{id?}', 'EntregaveisController@save')->name('entregavel-save')->middleware('permission:criar entregaveis|editar entregaveis');
    Route::get('/ativa_desativa/{id}', 'EntregaveisController@ativa_desativa')->name('entregavel-ativa_desativa')->middleware('permission:deletar entregaveis');
});
