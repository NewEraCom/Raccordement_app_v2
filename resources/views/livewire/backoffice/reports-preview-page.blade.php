<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    @if ($client->validations->count() != 0)
                    {{-- @role('admin') --}}
                    @if(in_array(Auth::user()->email, ['o.oma@gmail.com', 'j.sas@gmail.com','b.chabab@neweracom.ma']))
    @if($client->phase_one != 1)
        <button class="btn btn-danger shadow-none" data-bs-toggle="modal" data-bs-target='#refuser-modal'>
            <i class="uil-times-circle me-2"></i> À Modifier
        </button>
        <button class="btn btn-success shadow-none" data-bs-toggle="modal" data-bs-target='#valider-modal'>
            <i class="uil-check-circle me-2"></i> Valider 
        </button>
    @endif
@endif
                    {{-- @endrole --}}
                    <a href="{{ route('pdf',[ $client]) }}" class="btn btn-primary shadow-none">
                        <i class="ri-download-2-line me-2"></i>
                        Télécharger le rapport
                    </a>
                    @endif
                </div>
                <h4 class="page-title">Rapport De : {{ $client->name }}</h4>
            </div>
        </div>
    </div>

    @role('controller')
    @if ($client->phase_two != 1)
    <div class="card">
        <div class="card-header">
            <h4>Observation du contrôle qualité</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <form wire:submit.prevent='feedback'>
                    <div class="col-12">
                        <label for="">Choisissez les commentaires ci-dessous</label>
                        <div class="mt-2">
                            <div class="form-check form-check-inline mb-2">
                                <input type="checkbox" class="form-check-input" wire:model='commentaire'
                                    id="customCheck1" value="Erreur SIP">
                                <label class="form-check-label" for="customCheck1">Erreur SIP</label>
                            </div>
                            <div class="form-check form-check-inline mb-2">
                                <input type="checkbox" class="form-check-input" wire:model='commentaire'
                                    id="customCheck2" value="Erreur Nom client">
                                <label class="form-check-label" for="customCheck2">Erreur Nom client</label>
                            </div>
                            <div class="form-check form-check-inline mb-2">
                                <input type="checkbox" class="form-check-input" wire:model='commentaire'
                                    id="customCheck3" value="Erreur Adresse">
                                <label class="form-check-label" for="customCheck3">Erreur Adresse</label>
                            </div>
                            <div class="form-check form-check-inline mb-2">
                                <input type="checkbox" class="form-check-input" wire:model='commentaire'
                                    id="customCheck4" value="Erreur Numéro de téléphone">
                                <label class="form-check-label" for="customCheck4">Erreur Numéro de téléphone</label>
                            </div>
                            <div class="form-check form-check-inline mb-2">
                                <input type="checkbox" class="form-check-input" wire:model='commentaire'
                                    id="customCheck5" value="Nom de technicien à ajouter dans le fichier de suivi">
                                <label class="form-check-label" for="customCheck5">Nom de technicien à ajouter dans le
                                    fichier de suivi</label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="form-check form-check-inline mb-2">
                                <input type="checkbox" class="form-check-input" wire:model='commentaire'
                                    id="customCheck6" value="Problème entrée de câble 1FO">
                                <label class="form-check-label" for="customCheck6">Problème entrée de câble 1FO</label>
                            </div>
                            <div class="form-check form-check-inline mb-2">
                                <input type="checkbox" class="form-check-input" wire:model='commentaire'
                                    id="customCheck7" value="Problème dénudée de câble 1FO">
                                <label class="form-check-label" for="customCheck7">Problème dénudée de câble 1FO</label>
                            </div>
                            <div class="form-check form-check-inline mb-2">
                                <input type="checkbox" class="form-check-input" wire:model='commentaire'
                                    id="customCheck8" value="Problème Lovage brins">
                                <label class="form-check-label" for="customCheck8">Problème Lovage brins</label>
                            </div>
                            <div class="form-check form-check-inline mb-2">
                                <input type="checkbox" class="form-check-input" wire:model='commentaire'
                                    id="customCheck9" value="Problème Etiquetage">
                                <label class="form-check-label" for="customCheck9">Problème Etiquetage</label>
                            </div>
                            <div class="form-check form-check-inline mb-2">
                                <input type="checkbox" class="form-check-input" wire:model='commentaire'
                                    id="customCheck10" value="PV incomplet">
                                <label class="form-check-label" for="customCheck10">PV incomplet</label>
                            </div>
                            <div class="from-check from-check-inline mb-2">
                                <input type="checkbox" class="form-check-input" wire:model='commentaire'
                                    id="customCheck11" value="Schéma incomplet">
                                <label class="form-check-label" for="customCheck11">Schéma incomplet</label>
                            </div>
                        </div>
                        <div class="form-floating mb-2 mt-2">
                            <select class="form-select" id="floatingSelect" aria-label="Floating label select example"
                                wire:model='note'>
                                <option selected>-</option>
                                <option value="4">Mauvais</option>
                                <option value="6">Moyen</option>
                                <option value="8">Bien</option>
                                <option value="10">Super</option>
                            </select>
                            <label for="floatingSelect">Note de rapport</label>
                        </div>
                    </div>
                    <div class="col-12 d-grid">
                        <button type="submit" class="btn btn-primary shadow-none">
                            <span wire:loading.remove wire:target="feedback">Envoyer</span>
                            <span wire:loading wire:target="feedback">
                                <span class="spinner-border spinner-border-sm me-2" role="status"
                                    aria-hidden="true"></span>
                                Chargement...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    @endrole

    @role('responsable')
    <div class="card">
        <div class="card-body">
            <h4>Feedback : </h4>
            <p>Feedback de BO : {{ $client->phase_one == 1 ? 'Validé par BO' : 'Non validé par BO' }}</p>
            <p>Feedback de Contrôle Qualité : {{ $client->reportsFeedback->count() != 0 ?
                $client->reportsFeedback->last()->feedback : 'Pas encore de retour' }}</p>
        </div>
    </div>
    @endrole

    <div class="card">
        <div class="card-body">
            <div class="row p-2 ps-3 pe-3">
                <div class="col-3 text-center p-2 border">
                    <img src="{{ asset('assets/images/NewEraCom.png') }}" height="120" alt="" srcset="">
                </div>
                <div class="col-6 d-flex align-items-center justify-content-center border border-left-0 border-right-0">
                    <div class="text-center">
                        <h3>Rapport d'intervention</h3>
                        <h5></h5>
                    </div>
                </div>
                <div class="col-3 text-center p-2 border">
                    <img src="{{ asset('assets/images/Orange.png') }}" height="120" alt="" srcset="">

                </div>
            </div>
            <div class="row p-2 ps-3 pe-3">
                <div class="col-12 border">
                    <div class="bg-light p-2 mb-4 mt-2 text-center">
                        <h4>Informations sur l'intervention</h4>
                    </div>
                    <table class="table table-bordered table-centered">
                        <thead>
                            <tr>
                                <th class="text-center">Date de la demande</th>
                                <th class="text-center">Priorité</th>
                                <th class="text-center">Type d'intervention</th>
                                <th class="text-center">Date prévue de l'intervention</th>
                                <th class="text-center">Prestataire</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">{{ $client->created_at->format('d-m-Y') }}</td>
                                <td class="text-center"></td>
                                <td class="text-center">{{ $client->offre }}</td>
                                <td class="text-center">{{ $client->declarations[0]->created_at->format('d-m-Y') }}</td>
                                <td class="text-center">NewEraCom</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="bg-light p-2 mb-4 mt-2 text-center">
                        <h4>Informations du client</h4>
                    </div>
                    <table class="table table-bordered table-striped table-centered mb-4">
                        <tbody>
                            <tr>
                                <th width="30%">Nom du client</th>
                                <td width="70%">{{ $client->name }}</td>
                            </tr>
                            <tr>
                                <th>SIP</th>
                                <td>{{ $client->sip }}</td>
                            </tr>
                            <tr>
                                <th>Login internet</th>
                                <td>{{ $client->client_id }}</td>
                            </tr>
                            <tr>
                                <th>Adresse</th>
                                <td>{{ $client->address }}</td>
                            </tr>
                            <tr>
                                <th>Ville</th>
                                <td>{{ $client->city->name }}</td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>{{ $client->type }}</td>
                            </tr>
                            <tr>
                                <th>Débit</th>
                                <td>{{ $client->debit }} Méga</td>
                            </tr>
                            <tr>
                                <th>Routeur</th>
                                <td>{{ $client->routeur_type }}</td>
                            </tr>
                            <tr>
                                <th>Téléphone</th>
                                <td>{{ $client->returnPhoneNumber() }}</td>
                            </tr>
                            <tr>
                                <th>CIN description</th>
                                <td>{{ $client->validations->first()->cin_description ?? '' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="bg-light p-2 mb-4 mt-2 text-center">
                        <h4>Intervenants Prestataire/Client</h4>
                    </div>
                    <table class="table table-bordered table-centered">
                        <thead>
                            <tr>
                                <th class="text-center">Prestataire</th>
                                <th class="text-center">Nom de l'intervenant</th>
                                <th class="text-center">Téléphone</th>
                                <th class="text-center">Client/Mandataire</th>
                                <th class="text-center">Date de l'intervention</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">{{ $client->technicien->soustraitant->name }}</td>
                                <td class="text-center">{{ $client->technicien->user->getFullName() }}</td>
                                <td class="text-center">{{ $client->technicien->user->returnPhoneNumber() }}</td>
                                <td class="text-center">{{ $client->name }}</td>
                                <td class="text-center">{{ $client->created_at->format('d-m-Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="bg-light p-2 mb-4 mt-2 text-center">
                        <h4>Equipements remis au client</h4>
                    </div>
                    <table class="table table-bordered table-centered">
                        <thead>
                            <tr>
                                <th class="text-center" colspan="2">Qte</th>
                                <th class="text-center" colspan="2">Référence</th>
                                <th class="text-center">S/N</th>
                            </tr>
                            <tr>
                                <th class="text-center">Routeur</th>
                                <th class="text-center">Téléphone</th>
                                <th class="text-center">Téléphone</th>
                                <th class="text-center">MAC</th>
                                <th class="text-center">GPON</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td class="text-center">1</td>
                                <td class="text-center">0</td>
                                <td class="text-center">{{$client->routeur ? $client->declarations->last()->routeur->sn_mac : '-' }}</td>
                                <td class="text-center">{{ $client->routeur ?$client->declarations->last()->routeur->sn_gpon : '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @if ($client->declarations->count() != 0)
                    <div class="bg-light p-2 mb-4 d-flex align-items-center justify-content-between">
                        <h4 class="text-center">Informations de declaration</h4>
                        <!--<a href="#">Modifier</a>-->
                    </div>
                    <table class="table table-bordered table-striped table-centered mb-4">
                        <tbody>
                            <tr>
                                <th>Test signal</th>
                                <td>{{ $client->declarations->last()->test_signal }}</td>
                            </tr>
                            <tr>
                                <th>Type de passage de câble</th>
                                <td>{{ $client->declarations->last()->type_passage }}</td>
                            </tr>
                            <tr>
                                <th>SN_gpon</th>
                                <td>{{ $client->routeur ? $client->declarations->last()->routeur->sn_gpon : '' }}</td>
                            </tr>
                            <tr>
                                <th>SN_mac</th>
                                <td>{{ $client->routeur ? $client->declarations->last()->routeur->sn_mac : '' }}</td>
                            </tr>
                            <tr>
                                <th>SN_telephone</th>
                                <td>{{ $client->declarations->last()->sn_telephone }}</td>
                            </tr>
                            <tr>
                                <th>Nbr_Jarretières</th>
                                <td>{{ $client->declarations->last()->nbr_jarretieres }}</td>
                            </tr>
                            <tr>
                                <th>Cable_metre</th>
                                <td>{{ $client->declarations->last()->cable_metre }}</td>
                            </tr>
                            <tr>
                                <th>PTO</th>
                                <td>{{ $client->declarations->last()->pto }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @if ($client->declarations->first()->image_test_signal)
                    <div class="text-center mb-4">
                        <img src="data:image/png;base64,{{ $client->declarations->first()->image_test_signal }}"
                            width="550">
                        <h4 class="mt-2">Test Signal</h4>
                    </div>
                    @endif
                    @if ($client->declarations->first()->image_pbo_before)
                    <div class="text-center mb-4">
                        <img src="data:image/png;base64,{{ $client->declarations->first()->image_pbo_before }}"
                            width="550">
                        <h4 class="mt-2">Image PBO avant</h4>
                    </div>
                    @endif
                    @if ($client->declarations->first()->image_pbo_after)
                    <div class="text-center mb-4">
                        <img src="data:image/png;base64,{{ $client->declarations->first()->image_pbo_after }}"
                            width="550">
                        <h4 class="mt-2">Image PBO après</h4>
                    </div>
                    @endif
                    @if ($client->declarations->first()->image_pbi_before)
                    <div class="text-center mb-4">
                        <img src="data:image/png;base64,{{ $client->declarations->first()->image_pbi_before }}"
                            width="550">
                        <h4 class="mt-2">Image PBI avant</h4>
                    </div>
                    @endif
                    @if ($client->declarations->first()->image_pbi_after)
                    <div class="text-center mb-4">
                        <img src="data:image/png;base64,{{ $client->declarations->first()->image_pbi_after }}"
                            width="550">
                        <h4 class="mt-2">Image PBI après</h4>
                    </div>
                    @endif
                    @if ($client->declarations->first()->image_splitter)
                    <div class="text-center mb-4">
                        <img src="data:image/png;base64,{{ $client->declarations->first()->image_splitter }}"
                            width="550">
                        <h4 class="mt-2">Image Splitter</h4>
                    </div>
                    @endif
                    @if ($client->declarations->first()->image_passage_1)
                    <div class="text-center mb-4">
                        <img src="data:image/png;base64,{{ $client->declarations->first()->image_passage_1 }}"
                            width="550">
                        <h4 class="mt-2">Image Passage 1</h4>
                    </div>
                    @endif
                    @if ($client->declarations->first()->image_passage_2)
                    <div class="text-center mb-4">
                        <img src="data:image/png;base64,{{ $client->declarations->first()->image_passage_2 }}"
                            width="550">
                        <h4 class="mt-2">Image Passage 2</h4>
                    </div>
                    @endif
                    @if ($client->declarations->first()->image_passage_3)
                    <div class="text-center mb-4">
                        <img src="data:image/png;base64,{{ $client->declarations->last()->image_passage_3 }}"
                            width="550">
                        <h4 class="mt-2">Image Passage 3</h4>
                    </div>
                    @endif
                    @endif
                    @if ($client->validations->count() != 0)
                    <div class="bg-light p-2 mb-4 d-flex align-items-center justify-content-between">
                        <h4 class="text-center">Informations de validations</h4>
                        <!--<a href="#">Modifier</a>-->
                    </div>
                    <table class="table table-bordered table-striped table-centered mb-4">
                        <tbody>
                            <tr>
                                <th>Test Debit</th>
                                <td>{{ $client->validations->first()->test_debit }}</td>
                            </tr>
                        </tbody>
                    </table>
                    @if ($client->validations->first()->test_debit_image)
                    <div class="text-center mb-4">
                        <img src="data:image/png;base64,{{ $client->validations->first()->test_debit_image }}" width="550">
                        <h4 class="mt-2">Image test debit</h4>
                    </div>
                    @endif
                    @if ($client->validations->first()->test_debit_via_cable_image)
                    <div class="text-center mb-4">
                        <img src="data:image/png;base64,{{ $client->validations->first()->test_debit_via_cable_image }}"
                            width="550">
                        <h4 class="mt-2">Image tedt debit via cable</h4>
                    </div>
                    @endif
                    @if ($client->validations->first()->photo_test_debit_via_wifi_image)
                    <div class="text-center mb-4">
                        <img src="data:image/png;base64,{{ $client->validations->first()->photo_test_debit_via_wifi_image }}"
                            width="550">
                        <h4 class="mt-2">Image test debit via wifi</h4>
                    </div>
                    @endif
                    @if ($client->validations->first()->etiquetage_image)
                    <div class="text-center mb-4">
                        <img src="data:image/png;base64,{{ $client->validations->first()->etiquetage_image }}" width="550">
                        <h4 class="mt-2">Image Etiquetage</h4>
                    </div>
                    @endif
                    @if ($client->validations->first()->fiche_installation_image)
                    <div class="text-center mb-4">
                        <img src="data:image/png;base64,{{ $client->validations->first()->fiche_installation_image }}"
                            width="550">
                        <h4 class="mt-2">Fiche d'installation</h4>
                    </div>
                    @endif
                    @if ($client->validations->first()->router_tel_image)
                    <div class="text-center mb-4">
                        <img src="data:image/png;base64,{{ $client->validations->first()->router_tel_image }}" width="550">
                        <h4 class="mt-2">Image de routeur/tel</h4>
                    </div>
                    @endif
                    @if ($client->validations->first()->pv_image)
                    <div class="text-center mb-4">
                        <img src="data:image/png;base64,{{ $client->validations->first()->pv_image }}" width="550">
                        <h4 class="mt-2">Image PV</h4>
                    </div>
                    @endif
                    @if ($client->validations->first()->image_cin)
                    <div class="text-center mb-4">
                        <img src="data:image/png;base64,{{ $client->validations->first()->image_cin }}" width="550">
                        <h4 class="mt-2">CIN</h4>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div id="valider-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delete-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="valider">
                    <div class="modal-header">
                        <h4 class="modal-title" id="delete-modalLabel">Rapport Valide</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="fw-bold f-16">Voulez-vous vraiment valider ces rapports ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none">
                            <span wire:loading.remove wire:target="valider">Oui, valider</span>
                            <span wire:loading wire:target="valider">
                                <span class="spinner-border spinner-border-sm me-2" role="status"
                                    aria-hidden="true"></span>
                                Chargement...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="refuser-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="delete-modalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form wire:submit.prevent="refuser">
                    <div class="modal-header">
                        <h4 class="modal-title" id="delete-modalLabel">Rapport À Modifier</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <p class="f-s-16">Choisissez l'image que vous voulez que le technicien change</p>
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" wire:model='checkboxs'
                                    value="Test Signal" id="customCheck1">
                                <label class="form-check-label" for="customCheck1">Test Signal</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" wire:model='checkboxs'
                                    value="Image Splitter" id="customCheck2">
                                <label class="form-check-label" for="customCheck2">Image Splitter</label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" wire:model='checkboxs'
                                    value="Image PBO avant" id="customCheck3">
                                <label class="form-check-label" for="customCheck3">Image PBO avant</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" wire:model='checkboxs'
                                    value="Image PBO après" id="customCheck4">
                                <label class="form-check-label" for="customCheck4">Image PBO après</label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" wire:model='checkboxs'
                                    value="Image PBI avant" id="customCheck5">
                                <label class="form-check-label" for="customCheck5">Image PBI avant</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" wire:model='checkboxs'
                                    value="Image PBI après" id="customCheck6">
                                <label class="form-check-label" for="customCheck6">Image PBI après</label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" wire:model='checkboxs'
                                    value="Image test debit via cable" id="customCheck7">
                                <label class="form-check-label" for="customCheck7">Image test debit via cable</label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" wire:model='checkboxs'
                                    id="customCheck8">
                                <label class="form-check-label" for="customCheck8">Image test debit via wifi</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" wire:model='checkboxs'
                                    value="Image Etiquetage" id="customCheck9">
                                <label class="form-check-label" for="customCheck9" value="Image Etiquetage">Image
                                    Etiquetage</label>
                            </div>
                        </div>
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" wire:model='checkboxs'
                                    value="Image de routeur/tel" id="customCheck10">
                                <label class="form-check-label" for="customCheck10">Image de routeur/tel</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" wire:model='checkboxs' value="Image PV"
                                    id="customCheck11">
                                <label class="form-check-label" for="customCheck11">Image PV</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light shadow-none" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary shadow-none">
                            <span wire:loading.remove wire:target="refuser">Envoyer</span>
                            <span wire:loading wire:target="refuser">
                                <span class="spinner-border spinner-border-sm me-2" role="status"
                                    aria-hidden="true"></span>
                                Chargement...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</div>