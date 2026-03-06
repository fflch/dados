@extends('main')

@section('content')
<div class="container-lg">
    <div class="d-flex align-items-center p-3 my-3 rounded shadow-sm"  style="background-color: #273e74;"> 
        <div class="lh-1"> 
            <h1 class="h6 m-4 text-white lh-1" style="font-size: 3em;"> FFLCH em Números </div> </div>
    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-3 row-cols-lg-4">
        
        @component('components.restrito-card')   
            @slot('titulo')Graduação @endslot 
            @slot('url')restrito/graduacao @endslot
            @slot('icon') 
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" class="bd-placeholder-img card-img-top" fill="#000000" viewBox="0 0 256 256"><path d="M250.82,90.71l-120-64a5.94,5.94,0,0,0-5.64,0l-120,64a6,6,0,0,0,0,10.58L34,116.67v49.62a14,14,0,0,0,3.55,9.32C50.42,189.94,79.29,214,128,214a127.21,127.21,0,0,0,50-9.73V240a6,6,0,0,0,12,0V198.35a113.18,113.18,0,0,0,28.45-22.75,13.91,13.91,0,0,0,3.55-9.31V116.67l28.82-15.38a6,6,0,0,0,0-10.58ZM128,202c-44,0-70-21.56-81.52-34.41a2,2,0,0,1-.48-1.3V123.07l79.18,42.22a6,6,0,0,0,5.64,0L178,140.13v51C165,197.35,148.45,202,128,202Zm82-35.71a2,2,0,0,1-.48,1.3A100.25,100.25,0,0,1,190,184.3V133.73l20-10.66Zm-22.15-45a6.27,6.27,0,0,0-1-.71l-56-29.86a6,6,0,0,0-5.64,10.58L175.25,128,128,153.2,20.75,96,128,38.8,235.25,96Z"></path></svg>
            @endslot
        @endcomponent 
        @component('components.restrito-card')   
            @slot('titulo')Pós-graduação @endslot 
            @slot('url')restrito/posgraduacao @endslot
            @slot('icon') 
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" class="bd-placeholder-img card-img-top" fill="#000000" viewBox="0 0 256 256"><path d="M126,136a6,6,0,0,1-6,6H72a6,6,0,0,1,0-12h48A6,6,0,0,1,126,136Zm-6-38H72a6,6,0,0,0,0,12h48a6,6,0,0,0,0-12Zm110,62.62V224a6,6,0,0,1-9,5.21l-25-14.3-25,14.3a6,6,0,0,1-9-5.21V198H40a14,14,0,0,1-14-14V56A14,14,0,0,1,40,42H216a14,14,0,0,1,14,14V87.38a49.91,49.91,0,0,1,0,73.24ZM196,86a38,38,0,1,0,38,38A38,38,0,0,0,196,86ZM162,186V160.62a50,50,0,0,1,56-81.51V56a2,2,0,0,0-2-2H40a2,2,0,0,0-2,2V184a2,2,0,0,0,2,2Zm56-17.11a49.91,49.91,0,0,1-44,0v44.77l19-10.87a6,6,0,0,1,6,0l19,10.87Z"></path></svg>
            @endslot
        @endcomponent 
        @component('components.restrito-card')   
            @slot('titulo')Docentes @endslot 
            @slot('url')restrito/docentes @endslot
            @slot('icon')  
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" class="bd-placeholder-img card-img-top" fill="#000000" viewBox="0 0 256 256"><path d="M216,42H40A14,14,0,0,0,26,56V200a14,14,0,0,0,14,14H53.39a6,6,0,0,0,5.42-3.43,50,50,0,0,1,90.38,0,6,6,0,0,0,5.42,3.43H216a14,14,0,0,0,14-14V56A14,14,0,0,0,216,42ZM78,144a26,26,0,1,1,26,26A26,26,0,0,1,78,144Zm140,56a2,2,0,0,1-2,2H158.27a62.34,62.34,0,0,0-31.48-27.61,38,38,0,1,0-45.58,0A62.34,62.34,0,0,0,49.73,202H40a2,2,0,0,1-2-2V56a2,2,0,0,1,2-2H216a2,2,0,0,1,2,2ZM198,80v96a6,6,0,0,1-6,6H176a6,6,0,0,1,0-12h10V86H70V96a6,6,0,0,1-12,0V80a6,6,0,0,1,6-6H192A6,6,0,0,1,198,80Z"></path></svg>
            @endslot
        @endcomponent 
        @component('components.restrito-card')   
            @slot('titulo')Pesquisa @endslot 
            @slot('url')restrito/pesquisa @endslot
            @slot('icon') 
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" class="bd-placeholder-img card-img-top" fill="#000000" viewBox="0 0 256 256"><path d="M228.24,219.76l-51.38-51.38a86.15,86.15,0,1,0-8.48,8.48l51.38,51.38a6,6,0,0,0,8.48-8.48ZM38,112a74,74,0,1,1,74,74A74.09,74.09,0,0,1,38,112Z"></path></svg>@endslot
        @endcomponent 
        @component('components.restrito-card')   
            @slot('titulo')Internacional @endslot 
            @slot('url')restrito/internacional @endslot
            @slot('icon') 
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" class="bd-placeholder-img card-img-top" fill="#000000" viewBox="0 0 256 256"><path d="M128,26A102,102,0,1,0,230,128,102.12,102.12,0,0,0,128,26Zm81.57,64H169.19a132.58,132.58,0,0,0-25.73-50.67A90.29,90.29,0,0,1,209.57,90ZM218,128a89.7,89.7,0,0,1-3.83,26H171.81a155.43,155.43,0,0,0,0-52h42.36A89.7,89.7,0,0,1,218,128Zm-90,87.83a110,110,0,0,1-15.19-19.45A124.24,124.24,0,0,1,99.35,166h57.3a124.24,124.24,0,0,1-13.46,30.38A110,110,0,0,1,128,215.83ZM96.45,154a139.18,139.18,0,0,1,0-52h63.1a139.18,139.18,0,0,1,0,52ZM38,128a89.7,89.7,0,0,1,3.83-26H84.19a155.43,155.43,0,0,0,0,52H41.83A89.7,89.7,0,0,1,38,128Zm90-87.83a110,110,0,0,1,15.19,19.45A124.24,124.24,0,0,1,156.65,90H99.35a124.24,124.24,0,0,1,13.46-30.38A110,110,0,0,1,128,40.17Zm-15.46-.84A132.58,132.58,0,0,0,86.81,90H46.43A90.29,90.29,0,0,1,112.54,39.33ZM46.43,166H86.81a132.58,132.58,0,0,0,25.73,50.67A90.29,90.29,0,0,1,46.43,166Zm97,50.67A132.58,132.58,0,0,0,169.19,166h40.38A90.29,90.29,0,0,1,143.46,216.67Z"></path></svg> 
            @endslot
        @endcomponent 
        @component('components.restrito-card')   
            @slot('titulo')Extensão @endslot 
            @slot('url')restrito/extensao @endslot
            @slot('icon')  
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" class="bd-placeholder-img card-img-top" fill="#000000" viewBox="0 0 256 256"><path d="M252.51,108.8,227,57.75a14,14,0,0,0-18.78-6.27L182.66,64.26,129.53,50.2a6.1,6.1,0,0,0-3.06,0L73.34,64.26,47.79,51.48A14,14,0,0,0,29,57.75L3.49,108.8a14,14,0,0,0,6.26,18.78L36.9,141.16l55.61,39.72a6,6,0,0,0,2,.94l64,16A6.08,6.08,0,0,0,160,198a6,6,0,0,0,4.24-1.76l55.31-55.31,26.7-13.35a14,14,0,0,0,6.26-18.78Zm-53,35.16-35.8-28.68a6,6,0,0,0-8,.45c-18.65,18.79-39.5,16.42-52.79,7.92a2,2,0,0,1-.94-1.5,1.9,1.9,0,0,1,.51-1.55L146.43,78h33.86l28.41,56.82ZM14.11,115.69a2,2,0,0,1,.11-1.52L39.74,63.11a2,2,0,0,1,1.8-1.1,2,2,0,0,1,.89.21l22.21,11.1L37.32,128l-22.21-11.1A2,2,0,0,1,14.11,115.69Zm144.05,69.67-59.6-14.9L47.66,134.1,76.84,75.75,128,62.21l14.8,3.92a5.92,5.92,0,0,0-3,1.57L94.1,112.05a14,14,0,0,0,2.39,21.72c20.22,12.92,44.75,10.49,63.8-5.89L191,152.5Zm83.73-69.67a2,2,0,0,1-1,1.16L218.68,128,191.36,73.32l22.21-11.1a2,2,0,0,1,1.53-.11,2,2,0,0,1,1.16,1l25.52,51.06A2,2,0,0,1,241.89,115.69Zm-112,101.76a6,6,0,0,1-7.27,4.37L80.89,211.39a5.88,5.88,0,0,1-2-.94L52.52,191.64a6,6,0,1,1,7-9.77L84.91,200l40.61,10.15A6,6,0,0,1,129.88,217.45Z"></path></svg>
            @endslot
        @endcomponent 
        @component('components.restrito-card')   
            @slot('titulo')Estágios @endslot 
            @slot('url')restrito/estagios @endslot
            @slot('icon') 
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" class="bd-placeholder-img card-img-top" fill="#000000" viewBox="0 0 256 256"><path d="M106,112a6,6,0,0,1,6-6h32a6,6,0,0,1,0,12H112A6,6,0,0,1,106,112ZM230,72V200a14,14,0,0,1-14,14H40a14,14,0,0,1-14-14V72A14,14,0,0,1,40,58H82V48a22,22,0,0,1,22-22h48a22,22,0,0,1,22,22V58h42A14,14,0,0,1,230,72ZM94,58h68V48a10,10,0,0,0-10-10H104A10,10,0,0,0,94,48ZM38,72v42.79A186,186,0,0,0,128,138a185.91,185.91,0,0,0,90-23.22V72a2,2,0,0,0-2-2H40A2,2,0,0,0,38,72ZM218,200V128.37A198.12,198.12,0,0,1,128,150a198.05,198.05,0,0,1-90-21.62V200a2,2,0,0,0,2,2H216A2,2,0,0,0,218,200Z"></path></svg>
            @endslot
        @endcomponent 
        @component('components.restrito-card')   
            @slot('titulo')Administrativo @endslot 
            @slot('url')restrito/administrativo @endslot
            @slot('icon')  
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" class="bd-placeholder-img card-img-top" fill="#000000" viewBox="0 0 256 256"><path d="M248,210H230V94h2a6,6,0,0,0,0-12H182V46h2a6,6,0,0,0,0-12H40a6,6,0,0,0,0,12h2V210H24a6,6,0,0,0,0,12H248a6,6,0,0,0,0-12ZM218,94V210H182V94ZM54,46H170V210H142V160a6,6,0,0,0-6-6H88a6,6,0,0,0-6,6v50H54Zm76,164H94V166h36ZM74,80a6,6,0,0,1,6-6H96a6,6,0,0,1,0,12H80A6,6,0,0,1,74,80Zm48,0a6,6,0,0,1,6-6h16a6,6,0,0,1,0,12H128A6,6,0,0,1,122,80ZM80,126a6,6,0,0,1,0-12H96a6,6,0,0,1,0,12Zm42-6a6,6,0,0,1,6-6h16a6,6,0,0,1,0,12H128A6,6,0,0,1,122,120Z"></path></svg>
            @endslot
        @endcomponent 
        
    </div>
</div>
@endsection