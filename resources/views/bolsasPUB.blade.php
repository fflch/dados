@extends('layouts.app')

@section('title', 'Portal de Dados - FFLCH')

@section('content')
<x-header />

<div class="container-bolsas-pub">
    <h2 class="subtitulo">Bolsas PUB</h2>
    <p class="descricao">Os seguintes dados foram obtidos a partir da base de dados disponível no sistema Jupiter.</p>

    <button id="select-departments" class="select-button">Selecionar departamento(s)</button>
    
    <div id="departments-list" class="departments-list" style="display: none;">
        <label><input type="checkbox" value="departamento1"> Departamento 1</label><br>
        <label><input type="checkbox" value="departamento2"> Departamento 2</label><br>
        <label><input type="checkbox" value="departamento3"> Departamento 3</label><br>
        <!-- Adicione mais departamentos conforme necessário -->
    </div>
</div>
@endsection

<style>
    .container-bolsas-pub {
        background-color: #FFFFFF;
        padding: 20px;
        margin: 15px 5px 0 5px;
        border-radius: 5px;
        width: calc(100% - 80px);
        margin-top: 50px;    
    }

    .subtitulo {
        color: #052e70;
        font-size: 36px;
        margin: 0 0 10px 0;
    }

    .descricao {
        font-size: 16px;
        color: #333333;
    }

    .select-button {
        margin-top: 20px;
        padding: 10px 15px;
        background-color: #052e70;
        color: #ffffff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .select-button:hover {
        background-color: #034f9a;
    }

    .departments-list {
        margin-top: 10px;
        padding: 10px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectButton = document.getElementById('select-departments');
        const departmentsList = document.getElementById('departments-list');

        selectButton.addEventListener('click', function() {
            if (departmentsList.style.display === 'none') {
                departmentsList.style.display = 'block';
            } else {
                departmentsList.style.display = 'none';
            }
        });
    });
</script>
