<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\Eloquent\AuthorReposity;
use App\Repository\AuthorRepositoryInterface;
use App\Repository\BookCategoryReposityInterface;
use App\Repository\BookReposityInterface;
use App\Repository\CheckoutReposityInterface;
use App\Repository\Eloquent\BookCategoryReposity;
use App\Repository\Eloquent\BookReposity;
use App\Repository\Eloquent\CheckoutReposity;
use App\Repository\Eloquent\FineReposity;
use App\Repository\Eloquent\LibrarySettingReposity;
use App\Repository\Eloquent\LocationReposity;
use App\Repository\Eloquent\MemberReposity;
use App\Repository\Eloquent\PermissionReposity;
use App\Repository\Eloquent\PublisherReposity;
use App\Repository\Eloquent\RoleReposity;
use App\Repository\Eloquent\UserReposity;
use App\Repository\FineReposityInterface;
use App\Repository\LibrarySettingReposityInterface;
use App\Repository\LocationReposityInterface;
use App\Repository\MemberReposityInterface;
use App\Repository\PermissionReposityInterface;
use App\Repository\PublisherReposityInterface;
use App\Repository\RoleReposityInterface;
use App\Repository\UserReposityInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthorRepositoryInterface::class, AuthorReposity::class);
        $this->app->bind(BookCategoryReposityInterface::class, BookCategoryReposity::class);
        $this->app->bind(PublisherReposityInterface::class, PublisherReposity::class);
        $this->app->bind(LocationReposityInterface::class, LocationReposity::class);
        $this->app->bind(BookReposityInterface::class, BookReposity::class);
        $this->app->bind(MemberReposityInterface::class, MemberReposity::class);
        $this->app->bind(LibrarySettingReposityInterface::class, LibrarySettingReposity::class);
        $this->app->bind(CheckoutReposityInterface::class, CheckoutReposity::class);
        $this->app->bind(FineReposityInterface::class, FineReposity::class);
        $this->app->bind(UserReposityInterface::class, UserReposity::class);
        $this->app->bind(RoleReposityInterface::class, RoleReposity::class);
        $this->app->bind(PermissionReposityInterface::class, PermissionReposity::class);
    }
}
