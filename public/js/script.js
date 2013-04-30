

$(document).ready(function(){

	$("div.tabs").hide();
    // mostra somente  a primeira aba
    $("div.tabs:first").show();
    // seta a primeira aba como selecionada (na lista de abas)
    $(".menu_tabs li a:first").addClass("ativo");

    // quando clicar no link de uma aba
    $(".menu_tabs a").click(function(){
        // oculta todas as abas
        $("div.tabs").hide();
        // tira a seleção da aba atual
        $(".menu_tabs a").removeClass("ativo");

        // adiciona a classe selected na selecionada atualmente
        $(this).addClass("ativo");
        // mostra a aba clicada
        $($(this).attr("href")).show();

        // pra nao ir para o link
        return false;
	  
	});  
	  
});




















