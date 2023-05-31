<h1>Projeto Web: VueJs + Laravel</h1>
<p>Neste repositório, você encontrará um projeto web composto por duas partes: o Backend Laravel e o Front-End VueJS. 
  O objetivo desse projeto é apresentar um pouco do sertanejo brasileiro autêntico! Eu me desafiei um pouco nessa aplicação, 
  pois ela tem um significado especial para mim</p>
  <p> 
A ideia inicial é acessar as músicas e álbuns do Tião Carreiro & Pardinho. Através desses álbuns, pretendo criar um CRUD para gerenciar as informações dos álbuns e das faixas. No entanto, decidi ir além e utilizei a API do Deezer para obter as informações das músicas, incluindo um trecho de preview de 30 segundos. A API do Deezer é totalmente gratuita e oferece essa oportunidade de ouvir uma prévia das músicas.
  </p>
<h2>Tecnologias utilizadas</h2>
<ul>
    <li>Laravel 10</li>
    <li>VueJS 3</li>
    <li>Laravel Sanctum</li>
    <li>TypeScript</li>
    <li>CSS</li>
    <li>FontAwesome</li>
</ul>
  <h2>Front-End e Back-End separados:</h2>
  <p>Separar o front-end do back-end em um projeto de desenvolvimento de software oferece uma série de benefícios. Essa abordagem permite uma clara divisão de responsabilidades, com o front-end focado na apresentação e interação com o usuário, enquanto o back-end trata da lógica de negócios e processamento de dados. A separação também facilita a escalabilidade do sistema, pois cada camada pode ser dimensionada independentemente. Além disso, há uma maior reutilização de código, pois a mesma API de back-end pode ser usada por diferentes interfaces de usuário. A manutenção é mais fácil, já que as atualizações e correções podem ser implementadas de forma mais rápida e eficiente. A colaboração entre equipes também é facilitada, permitindo que os desenvolvedores de front-end e de back-end trabalhem de forma independente. A separação do front-end e do back-end também resulta em uma melhor experiência do usuário, com interfaces mais eficientes e responsivas. Por fim, essa abordagem permite o uso de tecnologias especializadas em cada camada, de acordo com os requisitos e demandas específicas. No entanto, é importante considerar as necessidades do projeto antes de decidir pela separação ou integração das camadas, pois essa abordagem pode não ser adequada para todos os casos.</p>
  
<h2>Instalando o sistema:</h2>
<p>Após clonar o repositório, você pode acessar a pasta "Front-End" e a pasta "Back-End". 
Eu já deixei as minhas variáveis de ambiente disponíveis para facilitar o acesso, mas lembre-se de dar uma olhada nas seguintes variávels: </p>
<p>No arquivo .env do framework Laravel, é necessário monitorar a seguinte variável: "FRONT_END_URL = http://localhost:8081". Além disso, será necessário configurar as demais variáveis de ambiente relacionadas ao banco de dados. Caso não faça isso, o client-side terá problemas com a configuração do CORS. Após isso, é só ir via linhas de comando até a pasta backend do projeto e <code>php artisan serve</code>.</p>
<p>
Para instalar o Front-End é um pouco mais especifico e complicado pois eu tentei utilizar as variáveis de ambiente do VueJS, no entanto sem sucesso.
 Para instalar o Front-End, caso o IP do Back-End não seja exatamente: "http://127.0.0.1:8000/". Irá dar problema no para se conectar. 
  Mas caso queira mudar, você terá que acessar 3 (três) arquivos: </br>
  frontend\src\components\AlbumModel.ts => ALL_ALBUMS_URL => Url de requisição do álbum, terá que trocar até a porta do sistema.</br>
  frontend\src\components\RequestModel.ts=> CODE_URL => Url de requisição do código para o front-end.</br>
  frontend\src\components\UserModel.ts => userUrl => Url de requisição de usuário, tanto login quanto registro.</br>
  frontend\src\components\SongModel.ts => SONGS_URl_ALBUM => Url de requisição das previews / músicas.</br>
</p>
<h2>1. Back-End - Informações da produção:</h2>
<p>O Back-End desempenha um papel fundamental em todos os sistemas Web. E o Laravel é capaz de lidar com eficiência a questão da segurança das APIs através do Laravel:Sanctum!</p>
<p>No entanto, decidi ir além e comecei a desenvolver meu próprio código/Middleware para acessar as rotas da API. Para aqueles que não estão familiarizados, as Middlewares do Laravel são trechos de código que podem ser executados antes do acesso a qualquer rota do sistema. Isso significa que sempre que alguém acessar uma rota HTTP do sistema, ela passará por esse código.</p>
<h3>Método de segurança:</h3>
<p>A ideia inicial era criar um código que pudesse ser solicitado apenas uma vez a cada 5 minutos! Essa é uma ótima maneira de manter a segurança do sistema front-end. No entanto, percebi que levaria um tempo para desenvolver essa solução e decidi explorar outro método semelhante, embora não funcione da mesma maneira.</p>
<p>O método que decidi utilizar segue uma abordagem semelhante. A cada 5 minutos, é enviado um código que varia constantemente. Esse código é gerado pelo Laravel, onde 5 strings são criptografadas e transformadas em uma sequência de 200 caracteres. Em seguida, o código é enviado como Header. A partir desse momento, o tempo de 5 minutos é armazenado no banco de dados.
Após o período de 5 minutos, o sistema Front-End não conseguirá acessar a rota. No entanto, foi programado de forma que ele possa acessar a rota novamente e obter um novo código para ser utilizado.</p>
<h3>Mudanças:</h3>
<p>Também fiz alterações na forma como o Laravel trata os tokens, limitando o envio de apenas um código por usuário. Isso facilita a segurança, embora possa reduzir um pouco a conveniência para usuários que desejam realizar tarefas na aplicação em outra plataforma ou terminal. No entanto, acredito que a segurança do sistema é um dos aspectos mais importantes para preservar a integridade do sistema.</p>
<p>A API também possui a funcionalidade de upload de arquivos. Isso significa que, além de consumir API's para obter informações e prévias, o sistema também atua como um CRUD, permitindo a criação, leitura, atualização e exclusão de dados.</p>
<h3>Sistemas de uploads:</h3>
<p>Como se trata de uma plataforma de música e imagens, é possível adicionar uma nova imagem para um determinado álbum ou até mesmo trocar a prévia da música. Através do recurso de upload de arquivos e da funcionalidade de atualização de informações do CRUD, é possível modificar um álbum por completo ou até mesmo alterar uma música ou imagem caso não estejam de acordo com as suas preferências. Isso oferece flexibilidade para personalizar e adaptar os conteúdos conforme desejado.</p>
<h3>Rotas do sistema:</h3>
<p>Lembre-se: o sistema é do Laravel, e aqui estou trabalhando com as API's. Então é sempre necessário antes da rota, colocar o <code>/api</code>.</p>
<table>
    <thead>
        <tr>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Método HTTP</th>
            <th>Rota</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Reseta as Informações</td>
            <td>Limpa as informações não utilizadas do banco de dados!</td>
            <td>GET</td>
            <td>/reset-data</td>
        </tr>
        <tr>
            <td>Pega o código exclusivo para a página Front-End</td>
            <td>Esse código atualiza a cada alguns minutos.</td>
            <td>GET</td>
            <td>/get-code</td>
        </tr>
        <tr>
            <td>Registro</td>
            <td>Registrar usuário</td>
            <td>POST</td>
            <td>/user/registro</td>
        </tr>
        <tr>
            <td>Login</td>
            <td>Efetuar login</td>
            <td>POST</td>
            <td>/user/login</td>
        </tr>
        <tr>
            <td>getUser</td>
            <td>Obter informações do usuário</td>
            <td>GET</td>
            <td>/user/user</td>
        </tr>
        <tr>
            <td>getAll</td>
            <td>Obter todos os álbuns</td>
            <td>GET</td>
            <td>/album/</td>
        </tr>
        <tr>
            <td>Criar novo album</td>
            <td>*</td>
            <td>POST</td>
            <td>/album/</td>
        </tr>
        <tr>
            <td>getIndexedElement</td>
            <td>Obter álbum específico</td>
            <td>GET</td>
            <td>/album/{id}</td>
        </tr>
        <tr>
            <td>getIndexedImage</td>
            <td>Obter imagem do álbum específico</td>
            <td>GET</td>
            <td>/album/{id}/image</td>
        </tr>
        <tr>
            <td>Deletar o álbum identificado pelo ID.</td>
            <td>*</td>
            <td>DELETE</td>
            <td>/album/{id}</td>
        </tr>
        <tr>
            <td>Atualiza o álbum identificado pelo ID.</td>
            <td>*</td>
            <td>POST</td>
            <td>/album/{id}</td>
        </tr>
        <tr>
            <td>getAll</td>
            <td>Obter todas as músicas</td>
            <td>GET</td>
            <td>/album/{id}/song</td>
        </tr>
        <tr>
            <td>Obtém todos os sons do álbum.</td>
            <td>*</td>
            <td>POST</td>
            <td>/album/{id}/song</td>
        </tr>
        <tr>
            <td>Deleta o preview identificado pelo álbum e pelo id do mesmo.</td>
            <td>*</td>
            <td>DELETE</td>
            <td>/album/{id}/song/{id_song}</td>
        </tr>
        <tr>
            <td>Atualizar / Troca o preview.</td>
            <td>*</td>
            <td>POST</td>
            <td>/album/{id}/song/{id_song}</td>
        </tr>
        <tr>
            <td>getIndexedElement</td>
            <td>Obter preview específica</td>
            <td>GET</td>
            <td>/album/{id}/song/{id_song}</td>
        </tr>
        <tr>
            <td>playPreview</td>
            <td>Reproduzir prévia da música</td>
            <td>GET</td>
            <td>/album/{id}/song/{id_song}/play</td>
        </tr>
    </tbody>
</table>
