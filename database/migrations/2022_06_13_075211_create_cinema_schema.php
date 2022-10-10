<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaSchema extends Migration
{
    /** ToDo: Create a migration that creates all tables for the following user stories

    For an example on how a UI for an api using this might look like, please try to book a show at https://in.bookmyshow.com/.
    To not introduce additional complexity, please consider only one cinema.

    Please list the tables that you would create including keys, foreign keys and attributes that are required by the user stories.

    ## User Stories

     **Movie exploration**
     * As a user I want to see which films can be watched and at what times
     * As a user I want to only see the shows which are not booked out

     **Show administration**
     * As a cinema owner I want to run different films at different times
     * As a cinema owner I want to run multiple films at the same time in different showrooms

     **Pricing**
     * As a cinema owner I want to get paid differently per show
     * As a cinema owner I want to give different seat types a percentage premium, for example 50 % more for vip seat

     **Seating**
     * As a user I want to book a seat
     * As a user I want to book a vip seat/couple seat/super vip/whatever
     * As a user I want to see which seats are still available
     * As a user I want to know where I'm sitting on my ticket
     * As a cinema owner I dont want to configure the seating for every show
     */
    public function up()
    {

        // movies
        Schema::create('movies', function(Blueprint $table)
        {
            $table->id();
            $table->string('film_name');
            $table->time('watch_at');
            $table->enum('booked_out', ['yes', 'not']);
            $table->tinyInteger('user_id');
            $table->timestamps();
        });

        //cinemas
        Schema::create('cinemas', function(Blueprint $table)
        {
            $table->id();
            $table->string('cinema_name');
            $table->string('location');
            $table->timestamps();
        });


        // rooms
        Schema::create('cinema_rooms', function(Blueprint $table)
        {
            $table->id();
            $table->string('room_name');
            $table->unsignedInteger('cinema_id');
            $table->foreign('cinema_id')->references('id')->on('cinemas')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });


        //Seat plans
        Schema::create('room_ticket_seat_pricings', function(Blueprint $table){
            $table->id();
            $table->interger('room_id');
            $table->integer('seat_type');
            $table->integer('starting_seat_number');
            $table->integer('end_seat_number');
            $table->integer('seat_ticket_price');
            $table->foreign('room_id')->references('id')->on('cinema_rooms')->onDelete('cascade');
        });


        //shows
        Schema::create('shows', function(Blueprint $table)
        {
            $table->id();
            $table->integer('movie_id');
            $table->integer('cinema_id');
            $table->integer('room_id');
            $table->date('show_date');
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->foreign('movie_id')->references('id')->on('movies')->onDelete('cascade');
            $table->foreign('cinma_id')->references('id')->on('cinemas')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('cinema_rooms')->onDelete('cascade');
            $table->timestamps();
        });



        //show bookings
        Schema::create('bookings', function(Blueprint $table){
            $table->id();
            $table->integer('user_id');
            $table->double('show_id');
            $table->double('seat_number');
            $table->double('price');
            $table->foreign('show_id')->references('id')->on('shows');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
