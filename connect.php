<?php

/**
 * Classe responsável por criar e fornecer
 * uma conexão com o banco de dados.
 */
class Connect
{
    /**
     * Constantes com os dados de conexão.
     * Como são constantes da classe, seus valores
     * não podem ser alterados em tempo de execução.
     */
    private const HOST = "localhost";
    private const DBNAME = "aula01";
    private const USER = "root";
    private const PASS = "";

    /**
     * Retorna uma única instância de conexão com o banco.
     *
     * O tipo de retorno ": PDO" informa que este método
     * sempre deve retornar um objeto da classe PDO.
     *
     * @return PDO
     */
    public static function getInstance(): PDO
    {
        /**
         * A variável static mantém seu valor entre
         * diferentes chamadas do método.
         *
         * Isso significa que, depois que a conexão for criada
         * pela primeira vez, ela será reaproveitada nas próximas chamadas.
         */
        static $instance = null;

        /**
         * Se ainda não existe conexão, cria uma nova.
         */
        if ($instance === null) {
            /**
             * DSN = Data Source Name
             * É a string que informa ao PDO:
             * - qual banco está sendo usado (mysql)
             * - o host
             * - o nome do banco
             * - o charset
             */
            $dsn = "mysql:host=" . self::HOST . ";dbname=" . self::DBNAME . ";charset=utf8mb4";

            /**
             * Cria a conexão com o banco usando PDO.
             *
             * Parâmetros:
             * 1. $dsn -> string com as informações da conexão
             * 2. self::USER -> usuário do banco
             * 3. self::PASS -> senha do banco
             * 4. array de opções da conexão
             */
            $instance = new PDO($dsn, self::USER, self::PASS, [
                /**
                 * Faz o PDO lançar exceções em caso de erro.
                 * Isso facilita o tratamento de falhas.
                 */
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

                /**
                 * Define que os resultados das consultas serão
                 * retornados como array associativo.
                 *
                 * Exemplo:
                 * [
                 *   "id" => 1,
                 *   "nome" => "João"
                 * ]
                 */
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        }

        /**
         * Retorna a instância da conexão.
         * Se ela já existir, retorna a mesma.
         */
        return $instance;
    }
}