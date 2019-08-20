<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 11px;
        }

        img {
            width: 70px;
            height: 70px;
            position: absolute;
        }

        .identityTitle {
            position: absolute;
            top: 1.5cm;
            left: 7cm;
        }

        .adhesionTitle {
            position: absolute;
            top: 8cm;
            left: 7cm;
        }

        .activitiesTitle {
            position: absolute;
            top: 11.5cm;
            left: 2cm;
        }

        .receiptTitle {
            position: absolute;
            top: 16cm;
            left: 5cm;
        }

        .adherentIdentityTitle {
            position: absolute;
            top: 17cm;
            left: 7cm;
        }

        .userIdentity {
            position: absolute;
            top: 2cm;
            left: 2cm;
        }

        .partnerIdentity {
            position: absolute;
            top: 2cm;
            left: 11cm;
        }

        .adhesion {
            position: absolute;
            top: 8.5cm;
            left: 2cm;
        }

        .amount {
            position: absolute;
            top: 8.5cm;
            left: 11cm;
        }

        .paymentType {
            position: absolute;
            top: 9.5cm;
            left: 5cm;
        }

        .notaBene {
            position: absolute;
            top: 10.5cm;
            left: 3cm;
        }

        .activities {
            position: absolute;
            top: 12.5cm;
            left: 3cm;
        }

        .beforeInvoice {
            position: absolute;
            top: 15cm;
            width: 19cm;
            border: 1px solid black;
        }

        .imgReceipt{
            position: absolute;
            top: 16cm;
            left: 2cm;
            width: 70px;
            height: 70px;
        }

        .paymentReceiptAdherent {
            position: absolute;
            top: 18cm;
            left: 2cm;
        }

        .paymentReceiptAdherent2 {
            position: absolute;
            top: 18cm;
            left: 10cm;
        }

        .adhesionTypeReceipt {
            position: absolute;
            top: 21cm;
            left: 2cm;
        }

        .deliveredReceipt {
            position: absolute;
            top: 23cm;
            left: 6cm;
        }
    </style>

</head>
<body>
<img src="{{base_path()}}/resources/assets/img/logo.jpg">
<h1 style="text-align: center"> Bulletin d'adhésion à REVV pour l'année {{date('Y')}}</h1>

<div class="identities">

    <h2 class="identityTitle">Votre Identité</h2>

    <div class="userIdentity">
        <h3>Adhérent :</h3>
        <p><b>Nom</b> : {{$user->lastname}}</p>
        <p><b>Prénom</b>: {{$user->firstname}}</p>
        <p><b>Adresse</b> : {{$user->address_line1}}</p>
        <p><b>Complément d'adresse</b> : {{$user->address_line2}}</p>
        <p><b>CP + Ville </b>: {{$user->zipcode}} {{$user->city}}</p>
        <p><b>date de naissance</b> : {{\Carbon\Carbon::parse($user->birthdate)->format('d/m/Y')}}</p>
        <p><b>Téléphone</b> : {{$user->phone_number_1}} / {{$user->phone_number_2}}</p>
    </div>

    <div class="partnerIdentity">
        <h3>Conjoint :</h3>
        <p><b>Nom</b> : {{$user->lastname_joint}}</p>
        <p><b>Prénom</b> : {{$user->firstname_joint}}</p>
        <p><b>Date de naissance</b> : {{$user->birthdate_joint}}</p>
        <p><b>E-mail</b> : {{$user->email_joint}}</p>
    </div>

</div>

<h2 class="adhesionTitle">Votre adhésion</h2>

<p class="adhesion"><b>Type d'adhésion</b> : </p>
<p class="amount"><b>Montant de l'adhésion</b> :</p>

<p class="paymentType"> Paiement par <b>chèque</b> ou <b>espèces</b> (rayez la mention inutile)</p>
<p class="notaBene"><b>NB</b> : L'adhésion donne droit à un marquage gratuit contre le vol, pensez à en profiter !</p>

<h2 class="activitiesTitle">Je suis prêt à participer à certaines actions de REVV (facultatif) </h2>

<div class="activities">
    <p>Permanence à la maison du vélo, un après-midi par semaine ou par mois (rayez la mention inutile)</p>
    <p>Autre suggestion : .......</p>
</div>

<hr class="beforeInvoice">

<img class="imgReceipt" src="{{base_path()}}/resources/assets/img/logo.jpg">

<h2 class="receiptTitle">Récipissé de la cotisation pour l'année {{date('Y')}}</h2>

<h3 class="adherentIdentityTitle">Identité de l'adhérent</h3>

<div class="paymentReceiptAdherent">
    <p><b>Numéro d'abonné</b> : {{$user->id}}</p>
    <p><b>Nom</b> : {{$user->lastname}}</p>
    <p><b>Prénom</b>: {{$user->firstname}}</p>
    <p><b>Téléphone </b>: {{$user->phone_number_1}} / {{$user->phone_number_2}}</p>
</div>

<div class="paymentReceiptAdherent2">
    <p><b>Adresse</b> : {{$user->address_line1}}</p>
    <p><b>Complément d'adresse</b> : {{$user->address_line2}}</p>
    <p><b>Code postal</b> : {{$user->zipcode}}</p>
    <p><b>Ville</b> : {{$user->city}}</p>
</div>

<div class="adhesionTypeReceipt">
    <p><b>Type d'adhésion</b> : </p>
    <p><b>Montant de l'adhésion</b> :</p>
</div>

<div class="deliveredReceipt">
    <p><b>Récipissé délivré le </b>:</p>
    <p><b> Par (nom + signature) </b>: </p>
</div>

</body>

</html>