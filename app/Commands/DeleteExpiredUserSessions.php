<?php
// This is an example code from the course
// TODO

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class DeleteExpiredUserSessions extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Auth';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'auth:cleanup';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Removes expired user sessions';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'command:name [arguments] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $users = new UserModel();
        $deletedRows = $users->deleteExpiredSessions();

        echo "$deletedRows row(s) deleted";
    }
}
