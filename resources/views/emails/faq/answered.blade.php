<x-mail::message>
    # Halo {{ $faq->nama }}

    Terima kasih telah mengirimkan pertanyaan kepada kami melalui website **NOTO 19**.

    ---

    ### ❓ Pertanyaan:

    > _{{ $faq->pertanyaan }}_

    ---

    ### Berikut jawaban dari tim NOTO 19:

    > **{{ $faq->jawaban }}**

    ---

    Jika ada pertanyaan lain, jangan ragu untuk menghubungi kembali melalui website kami.

    <x-mail::button :url="'/'">
        Kunjungi Webiste
    </x-mail::button>

    Terima kasih,<br>
    **{{ config('app.name') }}** Team NOTO 19
</x-mail::message>
