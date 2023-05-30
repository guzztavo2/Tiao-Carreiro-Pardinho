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
            <td>N/A</td>
            <td>N/A</td>
            <td>GET</td>
            <td>/</td>
        </tr>
        <tr>
            <td>N/A</td>
            <td>N/A</td>
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
            <td>N/A</td>
            <td>N/A</td>
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
            <td>N/A</td>
            <td>N/A</td>
            <td>DELETE</td>
            <td>/album/{id}</td>
        </tr>
        <tr>
            <td>N/A</td>
            <td>N/A</td>
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
            <td>N/A</td>
            <td>N/A</td>
            <td>POST</td>
            <td>/album/{id}/song</td>
        </tr>
        <tr>
            <td>N/A</td>
            <td>N/A</td>
            <td>DELETE</td>
            <td>/album/{id}/song/{id_song}</td>
        </tr>
        <tr>
            <td>N/A</td>
            <td>N/A</td>
            <td>POST</td>
            <td>/album/{id}/song/{id_song}</td>
        </tr>
        <tr>
            <td>getIndexedElement</td>
            <td>Obter música específica</td>
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
