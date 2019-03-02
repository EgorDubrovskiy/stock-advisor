<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Illuminate\Support\Facades\DB;
use App\Events\SaveAvatarEvent;

class MoveAvatarsToDiskFromUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $results = DB::table('users')->select('id', 'profile_picture')->get();

        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar', 256)->nullable();
            $table->dropColumn('profile_picture');
        });


        foreach ($results as $result) {
            if (!$result->profile_picture) {
                continue;
            }

            $blobString = $result->profile_picture;
            $image = imagecreatefromstring(utf8_decode($blobString));
            $imagePath = public_path('storage/app/avatars');
            imagepng($image, $imagePath . '/avatar_' . $result->id . '.png');
            imagedestroy($image);

            DB::table('users')
                ->where('id', $result->id)
                ->update(['avatar' => 'avatar_' . $result->id . '.png']);

            event(new SaveAvatarEvent('avatar_' . $result->id . '.png'));
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->binary('profile_picture')->nullable();
            $table->dropColumn('avatar');
        });
    }
}
