function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        rua = (conteudo.logradouro);
        bairro = (conteudo.bairro);
        cidade = (conteudo.localidade);
        uf = (conteudo.uf);
        ibge = (conteudo.ibge);

        console.log('Rua: ' + rua + "\nBairro: " + bairro + "\ncidade: " + cidade + "\nUF: " + uf + "\nIBGE: " + ibge)
        alert('Rua: ' + rua + "\nBairro: " + bairro + "\ncidade: " + cidade + "\nUF: " + uf + "\nIBGE: " + ibge)
    } //end if.
    else {
        //CEP não Encontrado.
        alert("CEP não encontrado.");
    }
}

function getCep(){
    cep = document.getElementById("cep").value

    //console.log('https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback')

    //Cria um elemento javascript.
    var script = document.createElement('script');

    //Sincroniza com o callback.
    script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

    //Insere script no documento e carrega o conteúdo.
    document.body.appendChild(script);
}