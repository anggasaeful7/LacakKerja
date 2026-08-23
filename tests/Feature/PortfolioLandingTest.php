<?php

it('renders the LacakKerja portfolio landing page', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('Pekerjaan lapangan lebih')
        ->assertSee('Technician PWA')
        ->assertSee('Laravel 13')
        ->assertSee('Masuk ke workspace');
});
