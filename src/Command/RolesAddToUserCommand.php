<?php

namespace App\Command;

use App\Components\User\UserManager;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'roles:add-to-user',
    description: 'add roles to User',
)]
class RolesAddToUserCommand extends Command
{
    public function __construct(private UserRepository $userRepository, private UserManager $userManager)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $askId = new Question("Id'ni kiriting: ");
        $askRole = new Question("Role'ni kiriting: ");
        $questionHelper = $this->getHelper('question');

        $user = null;
        $role = null;

        // $user qiymati null'ga teng bo'lsa aylanma ishlaydi
        while (!$user) {
            // Ushbu qatorda id kiritishni so'rayapmiz va kiritilgan ma'lumotni id o'zgaruvchanida saqlayapmiz
            $id = $questionHelper->ask($input, $output, $askId);

            // Bu yerda id'ga mos user'ni bazadan topib chiqib uni $user o'zgaruvchanida saqlayapmiz
            $user = $this->userRepository->find($id);

            // Agar bunday id'li user topilmasa quyidagi xabar chiqsin
            if ($user === null) {
                $io->warning("Bunday foydalanuvchi mavjud emas");
            }
        }

        // Toki to'g'ri formatdagi role kiritilmaguncha role kiritishni so'rayapmiz
        while (!preg_match('/^ROLE_[A-Z]{4,20}$/', $role)) {
            // Bu yerda role so'rayapmiz
            $role = $questionHelper->ask($input, $output, $askRole);

            // Kiritilgan role noto'g'ri bo'lsa quyidagi xabar chiqadi
            if (!preg_match('/^ROLE_[A-Z]{4,20}$/', $role)) {
                $io->warning("Noto'g'ri role kiritdingiz");
            }
        }

        // User'ni role massivini yangi massivga olib olyapmiz
        $roles = $user->getRoles();

        // Agar roles massivida kiritilayotgan yangi role mavjud bo'lmasa if ishlasin deyapmiz
        if (!in_array($role, $roles, true)) {
            // ushbu massivga qo'shimcha yangi kiritilgan role'ni qo'shdik
            $roles[] = $role;

            // Yangi yaratilgan massivni user'ni roles qiymatiga set qildik
            $user->setRoles($roles);

            // User'ni saqladik
            $this->userManager->save($user, true);

            $io->success("Role added successfully");
        }

        return Command::SUCCESS;
    }
}















