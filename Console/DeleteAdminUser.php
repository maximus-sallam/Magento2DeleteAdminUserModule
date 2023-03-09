namespace MaximusSallam\DeleteAdminUserModule\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Magento\User\Model\UserFactory;
use Magento\Framework\Exception\NoSuchEntityException;

class DeleteAdminUser extends Command
{
    protected $userFactory;

    public function __construct(
        UserFactory $userFactory,
        string $name = null
    ) {
        $this->userFactory = $userFactory;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this->setName('admin:user:delete')
//            ->setDescription('Delete an admin user by ID');
//        $this->addArgument('user_id', \Symfony\Component\Console\Input\InputArgument::REQUIRED, 'Admin user ID');
	    ->setDescription('Delete an admin user by username');
   	$this->addArgument('username', \Symfony\Component\Console\Input\InputArgument::REQUIRED, 'Admin user username');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//        $userId = $input->getArgument('user_id');
//        $user = $this->userFactory->create();
//        try {
//            $user->load($userId);
//            $user->delete();
//            $output->writeln("Admin user $userId deleted successfully.");
//        } catch (NoSuchEntityException $e) {
//            $output->writeln("Admin user $userId not found.");
//        } catch (\Exception $e) {
//            $output->writeln("Error deleting admin user $userId: " . $e->getMessage());
    	$username = $input->getArgument('username');
    	$user = $this->userFactory->create()->loadByUsername($username);
    	if ($user->getId()) {
        	$user->delete();
        	$output->writeln("Admin user $username deleted successfully.");
    	} else {
        	$output->writeln("Admin user $username not found.");
        }
    }
}
