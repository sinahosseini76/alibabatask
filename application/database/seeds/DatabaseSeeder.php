<?php

use Illuminate\Database\Seeder;
use Modules\Admin\Database\seeds\AdminSeeder;
use Modules\Admin\Database\seeds\PermissionSeeder;
use Modules\Article\Database\seeds\ArticlePermissionSeeder;
use Modules\Article\Database\seeds\ArticleSeeder;
use Modules\Category\Database\seeds\CategoryPermissionSeeder;
use Modules\Category\Database\seeds\CategorySeeder;
use Modules\Payment\Database\seeds\GatewaySeeder;
use Modules\Plan\Database\seeds\PlanFlagSeeder;
use Modules\Plan\Database\seeds\PlanSeeder;
use Modules\Plan\Database\seeds\PlanServiceCategorySeeder;
use Modules\Plan\Database\seeds\PlanServiceSeeder;
use Modules\Ticket\Database\seeds\TicketAdminManagerSeeder;
use Modules\Ticket\Database\seeds\TicketDepartmentSeeder;
use Modules\Ticket\Database\seeds\TicketPrioritySeeder;
use Modules\Ticket\Database\seeds\TicketStatusSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(CategoryPermissionSeeder::class);
        $this->call(ArticlePermissionSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ArticleSeeder::class);
    }
}
