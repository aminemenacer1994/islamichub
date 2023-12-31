<?php

use App\Http\Controllers\AhadithController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AllahNamesController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CharityController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\HadithNawawiController;
use App\Http\Controllers\HadithQudsiController;
use App\Http\Controllers\HadithShahController;
use App\Http\Controllers\MailingListController;
use App\Http\Controllers\videoController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\CorrectionController;
use App\Http\Controllers\LikedController;
use App\Http\Controllers\ProphetsController;
use App\Http\Controllers\QuranController;
use App\Http\Controllers\SurahController;


Route::get('/', function () {
    return view('home');
});
Route::get('/welcome', function () {
    return view('home');
});


Route::get('/get_juzs', [SurahController::class, 'getJuzs']);
Route::get('/get_surahs', [SurahController::class, 'getSurahs']);
Route::get('/get_ayahs', [SurahController::class, 'getAyahs']);
Route::get('/get_pages', [SurahController::class, 'getPages']);
Route::get('/get_informations', [SurahController::class, 'getInformations']);
Route::get('/tafseer/{id}/fetch', [SurahController::class, 'getTafseer']);


// likes
Route::get('api/fetch-likes', [LikedController::class, 'getLikes']);
Route::get('/likes', [LikedController::class, 'index']);

// ahadith
Route::get('/ahadith', [AhadithController::class, 'index']);


// frontend json files
Route::get('/allah_names', [AllahNamesController::class, 'index']);
Route::get('/reminders', [ReminderController::class, 'index']);
Route::get('/hadith_qudsi', [HadithQudsiController::class, 'index']);
Route::get('/hadith_shah', [HadithShahController::class, 'index']);

// mailing list
Route::get('/mailing_list', [MailingListController::class, 'index'])->name('mailing_list');
Route::get('api/fetch-mail', [MailingListController::class, 'getMail'])->name('mailing_list');
Route::post('api/subscribe', [MailingListController::class, 'create']);

// correction
Route::post('api/submit-correction', [CorrectionController::class, 'submit']);
Route::get('/correction', [CorrectionController::class, 'index']);
Route::get('api/fetch-corrections', [CorrectionController::class, 'getCorrections']);

// nawawi
Route::get('/nawawi', [HadithNawawiController::class, 'index']);
Route::get('api/fetch-nawawis', [HadithNawawiController::class, 'getNawawis']);

// prophets
Route::get('/prophets', [ProphetsController::class, 'index'])->name('prophets');

// knowledge
Route::get('/knowledge', [knowledgeController::class, 'index'])->name('knowledge');

// video
Route::get('/video', [VideoController::class, 'index'])->name('video');

// contact
Route::get('/contact', [ContactController::class, 'index']);

// pricing
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');

// charity
Route::get('/charity', [CharityController::class, 'index'])->name('charity');

// volunteer
Route::get('/volunteer', [VolunteerController::class, 'index'])->name('volunteer');

// Auth routes
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

// dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('api/fetch-dashboard', [DashboardController::class, 'getDashboard'])->name('dashboard');

// users
Route::get('/users', [UserController::class, 'index']);
Route::get('api/fetch-users', [UserController::class, 'getUsers']);
Route::post('api/create-users', [UserController::class, 'createUsers']);
Route::post('api/update-users/{id}',  [UserController::class, 'updateUsers']);
Route::delete('api/delete-users/{id}',  [UserController::class, 'deleteUsers']);
Route::get('/profile', [UserController::class, 'getProfile']);


// feedback
Route::get('/feedback', [FeedbackController::class, 'index']);
Route::get('api/fetch-feedbacks', [FeedbackController::class, 'getFeedbacks']);
Route::post('api/send-message', [FeedbackController::class, 'sendMessage']);

// payment
Route::get('/payments', [PaymentController::class, 'index']);
Route::get('api/fetch-payments', [PaymentController::class, 'getPayments']);

// donations
Route::get('/donations', [DonationController::class, 'index']);
Route::get('api/fetch-donations', [DonationController::class, 'getDonations']);

// quran
Route::get('/quran', [QuranController::class, 'index']);


// Route::get('ManageProducts', 'ProductController@index')->middleware('auth');
