<?php
namespace MaximusSallam\DeleteAdminUserCommand\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Magento\User\Model\UserFactory;

class DeleteAdminUserCommand extends Command
{
    const USERNAME_ARGUMENT = 'username';

    protected $userFactory;

    public function __construct(UserFactory $userFactory)
    {
        $this->userFactory = $userFactory;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('admin:user:delete')
            ->setDescription('Delete admin user by username')
            ->setDefinition([
                new InputArgument(
                    self::USERNAME_ARGUMENT,
                    InputArgument::REQUIRED,
                    'Username of the admin user to delete'
                )
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument(self::USERNAME_ARGUMENT);
        $user = $this->userFactory->create()->loadByUsername($username);

        if (!$user->getId()) {
            $output->writeln("<error>User with username '{$username}' does not exist.</error>");
            return 1;
        }

        try {
            $user->delete();
            $output->writeln("<info>Admin user '{$username}' has been deleted.</info>");
        } catch (\Exception $e) {
            $output->writeln("<error>Error deleting admin user '{$username}': " . $e->getMessage() . "</error>");
            return 1;
        }

        return 0;
    }
}
