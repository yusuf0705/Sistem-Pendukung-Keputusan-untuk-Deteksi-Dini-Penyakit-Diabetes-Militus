<h3>Hasil Analisis Diabetes Dini</h3>

@if($hasil['diabetes'] == 1)
    <p><strong>Hasil:</strong> Berisiko Diabetes</p>
@else
    <p><strong>Hasil:</strong> Tidak Berisiko Diabetes</p>
@endif

<p>Probabilitas: {{ round($hasil['probabilitas'] * 100, 2) }}%</p>
