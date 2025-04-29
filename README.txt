Primeiramente a pasta do projeto (DoacaoSangue) deve estar dentro dentro do diretório onde o XAMPP está instalado, e dentro da pasta htdocs.
Por exemplo: "C:\xampp\htdocs\DoacaoSangue" para o meu projeto.
Logo após executar o XAMPP e iniciar tanto o MySQL quanto o Apache, acessar o projeto por meio do navegador com o seguinte endereço: "localhost/DoacaoSangue/index.php".
Todos os usuários são cadastrados por padrão como usuários comuns, para criar o primeiro administrador, caso o banco de dados esteja vazio, deve-se preencher a tela de cadastro e modificar no banco de dados o valor do campo "tipo_usuario" de 0 para 1. Após isso, com um administrador criado, já é possível transformar um usuário comum para administrador via painel do administrador. 

As funcionalidades do aplicativo são:

Tela com opção de acesso ou cadastro de usuário.

Caso o usuário seja um usuário comum, ao logar ele pode tanto registrar uma oferta de doação de sangue quanto uma solicitação.

Caso o usuário seja um administrador, ele pode visualizar todas as ofertas e solicitações disponíveis e se quiser pode excluí-las, pode verificar os procedimentos viáveis para serem realizados (tipo sanguíneo de recebedor e doador compatíveis) e também pode tanto alterar os dados de um usuário como excluir um usuário.

O aplicativo conta com validações para e-mail, senha (mínimo 8 caracteres, sendo 1 maiúscula, 1 minúscula, 1 caractere especial e 1 número como requisitos obrigatórios) a senha é criptografada no banco. Validação para formato de número de telefone. Também conta com verificações que possibilitam visualizar procedimentos viáveis, onde há compatibilidade entre o doador e o receptor.

Conta com recursos como verificação de restrição de chave estrangeira na hora da exclusão do usuário, destruição da sessão caso o usuário exclua a própria conta, validações que impedem ações indesejadas, etc.

Essa é a primeira versão do aplicativo, desenvolvido inteiramente por Johan Debtil.  
