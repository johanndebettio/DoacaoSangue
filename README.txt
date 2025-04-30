Primeiramente a pasta do projeto (DoacaoSangue) deve estar dentro dentro do diretório onde o XAMPP está instalado, e dentro da pasta htdocs. 
Por exemplo: "C:\xampp\htdocs\DoacaoSangue" para o meu projeto.
Logo após executar o XAMPP e iniciar tanto o MySQL quanto o Apache, acessar o projeto por meio do navegador com o seguinte endereço: "localhost/DoacaoSangue/index.php" (Após a importação do banco de dados que funciona da seguinte forma: Deve ser criado no phpmyadmin o banco "doacao_sangue" e importar o arquivo mais atualizado "doacao_sangue_1.sql").
Todos os usuários são cadastrados por padrão como usuários comuns, para criar o primeiro administrador, caso o banco de dados esteja vazio, deve-se preencher a tela de cadastro e modificar no banco de dados o valor do campo "tipo_usuario" de 0 para 1. Após isso, com um administrador criado, já é possível transformar um usuário comum em administrador via painel do administrador. 

As funcionalidades do aplicativo são:

Tela com opção de acesso ou cadastro de usuário.

Caso o usuário seja um usuário comum, ao logar ele pode tanto registrar uma oferta de doação de sangue quanto uma solicitação e também visualizar as próprias solicitações e/ou ofertas.

Caso o usuário seja um administrador, ele pode visualizar todas as ofertas e solicitações disponíveis e se quiser pode excluí-las (há um filtro de pesquisa por local e por tipo sanguíneo), pode verificar os procedimentos viáveis e prontos para serem realizados (tipo sanguíneo de receptor e doador compatíveis) e também pode tanto alterar os dados de um usuário como excluir um usuário.

O aplicativo conta com validações para e-mail, senha (mínimo 8 caracteres, sendo 1 maiúscula, 1 minúscula, 1 caractere especial e 1 número como requisitos obrigatórios) a senha é criptografada no banco. Validação para formato de número de telefone e máscara. Também conta com verificações que possibilitam visualizar procedimentos viáveis, onde há compatibilidade entre o doador e o receptor (como citado anteriormente).

Conta com recursos como verificação de restrição de chave estrangeira na hora da exclusão do usuário, destruição da sessão caso o usuário exclua a própria conta, validações que impedem ações indesejadas, etc.

Os logins e senhas cadastrados até então são:

Usuários Comuns:
login: ana@gmail.com senha: Ana1234! 
login: felipe@gmail.com senha: Felipe123!
login: maria@gmail.com senha: Maria123!
login: joao@gmail.com senha: Joao123!

Administradores:
login: johan@gmail.com senha: Johan123!

Essa é a primeira versão do aplicativo, desenvolvido inteiramente por Johan Debtil.  
