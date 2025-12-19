use App\Http\Controllers\Auth\TeacherAuthController;

Route::get('teacher/login', [TeacherAuthController::class, 'showLogin'])->name('teacher.login');
Route::post('teacher/login', [TeacherAuthController::class, 'login']);

Route::get('teacher/signup', [TeacherAuthController::class, 'showSignup'])->name('teacher.signup');
Route::post('teacher/signup', [TeacherAuthController::class, 'signup']);

Route::post('teacher/logout', [TeacherAuthController::class, 'logout'])->name('teacher.logout');


use App\Http\Controllers\Teacher\DashboardController;

Route::middleware(['auth:teacher'])->prefix('teacher')->name('teacher.')->group(function() {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


use App\Http\Controllers\Teacher\ModuleController;

Route::prefix('teacher')->middleware(['auth'])->group(function () {
    Route::get('modules', [ModuleController::class, 'index'])->name('teacher.modules');
    Route::post('modules/upload', [ModuleController::class, 'upload'])->name('teacher.modules.upload');
    Route::post('modules/settings', [ModuleController::class, 'updateSettings'])->name('teacher.modules.settings');
    Route::post('modules/{material}/edit', [ModuleController::class, 'edit'])->name('teacher.modules.edit');
    Route::delete('modules/{material}/delete', [ModuleController::class, 'delete'])->name('teacher.modules.delete');
});

use App\Http\Controllers\Teacher\QuizController;

Route::prefix('teacher')->middleware(['auth:teacher'])->group(function () {
    Route::get('/quizzes', [QuizController::class, 'index'])->name('teacher.quizzes.index');
    Route::delete('/quizzes/{id}', [QuizController::class, 'destroy'])->name('teacher.quizzes.destroy');
});
