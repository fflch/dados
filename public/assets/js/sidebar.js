document.addEventListener('DOMContentLoaded', function() {
    // Função para alternar a visibilidade dos submenus
    function toggleSubmenu(expandableId, submenuId) {
        var expandable = document.getElementById(expandableId);
        var submenu = document.getElementById(submenuId);

        expandable.addEventListener('click', function(e) {
            e.preventDefault();
            if (submenu.style.display === 'block') {
                submenu.style.display = 'none';
            } else {
                submenu.style.display = 'block';
            }
        });
    }

    // Aplicando a função para os diversos itens
    toggleSubmenu('dadosProducaoAcademica', 'submenuDadosProducaoAcademica');
    toggleSubmenu('dadosInstitucionais', 'submenuDadosInstitucionais');
    toggleSubmenu('dadosPorCurso', 'submenuDadosPorCurso');
    toggleSubmenu('dadosPosGraduacao', 'submenuDadosPosGraduacao');
    toggleSubmenu('dadosGraduacao', 'submenuDadosGraduacao');
    toggleSubmenu('dadosPorAno', 'submenuDadosPorAno');
    toggleSubmenu('dadosPorCorRaca', 'submenuDadosPorCorRaca');
    toggleSubmenu('dadosPorNacionalidadeLocalidade', 'submenuDadosPorNacionalidadeLocalidade');
    toggleSubmenu('dadosPorIngresso', 'submenuDadosPorIngresso');
    toggleSubmenu('dadosBolsas', 'submenuDadosBolsas');
});