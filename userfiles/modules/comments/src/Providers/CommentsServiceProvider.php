<?php

namespace MicroweberPackages\Modules\Comments\Providers;

use Illuminate\Support\Facades\View;
use Livewire\Livewire;
use MicroweberPackages\Modules\Comments\Http\Livewire\Admin\AdminCommentsListComponent;
use MicroweberPackages\Modules\Comments\Http\Livewire\Admin\AdminSettingsModalComponent;
use MicroweberPackages\Modules\Comments\Http\Livewire\UserCommentListComponent;
use MicroweberPackages\Modules\Comments\Http\Livewire\UserCommentPreviewComponent;
use MicroweberPackages\Modules\Comments\Http\Livewire\UserCommentReplyComponent;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CommentsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('microweber-module-comments');
        $package->hasViews('microweber-module-comments');
        $package->hasRoute('api');
        $package->hasRoute('admin');
        $package->hasMigration('2023_00_00_000000_create_comments_table2');
        $package->hasMigration('2023_00_00_000001_add_deleted_at_to_comments_table');
        $package->runsMigrations(true);
    }

    public function register(): void
    {
        View::addNamespace('comments', normalize_path(__DIR__) . '/../resources/views');

        Livewire::component('comments::admin-comments', AdminCommentsListComponent::class);
        Livewire::component('comments::admin.settings-modal', AdminSettingsModalComponent::class);

        Livewire::component('comments::user-comment-reply', UserCommentReplyComponent::class);
        Livewire::component('comments::user-comment-list', UserCommentListComponent::class);
        Livewire::component('comments::user-comment-preview', UserCommentPreviewComponent::class);

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations/');
        $this->loadRoutesFrom(__DIR__ . '/../routes/admin.php');

        parent::register();

    }

}
