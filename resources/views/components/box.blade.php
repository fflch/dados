<div class="box">
    <h2>{{ $title }}</h2>
    <img src="{{ $image }}" alt="{{ $alt }}">
</div>

<style>

.box {
    background-color: #FFFFFF; /* Fundo branco */
    padding: 20px;
    width: 40%;
    height: 250px;
    text-align: center;
    margin: 10px;
    border-radius: 8px; /* Bordas arredondadas para um visual mais suave */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Sombra suave */
    transition: transform 0.3s ease; /* Adicionar efeito de hover */
}

.box:hover {
    transform: scale(1.05); /* Pequeno aumento ao passar o mouse */
}

.box img {
    max-width: 100%;
    height: auto;
    margin-top: 10px;
}

</style>