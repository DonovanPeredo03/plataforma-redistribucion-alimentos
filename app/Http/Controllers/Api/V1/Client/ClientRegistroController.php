<?php

namespace App\Http\Controllers\Api\V1\Client;

use App\Http\Requests\Api\V1\Client\ClientResourceRequest;
use App\Http\Resources\Api\V1\Client\ClientOrdenResource;
use App\Models\Orden;
use App\Models\OrdenDetalle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ClientRegistroController extends ClientController
{
    public function index()
    {
        $ordenes = Orden::delUsuario(auth()->id())         
            ->with('detalles.alimento')
            ->orderByDesc('id_orden')
            ->get();

        return $this->ok('Registros consultados correctamente.', ClientOrdenResource::collection($ordenes));
    }

    public function store(ClientResourceRequest $request)
    {
        $datos = $request->validated();   

        $orden = DB::transaction(function () use ($datos) {
            $idOrden = (Orden::max('id_orden') ?? 0) + 1;

            $orden = Orden::create([
                'id_orden'      => $idOrden,
                'id_usuario'    => auth()->id(),           
                'fecha_orden'   => now(),
                'estado'        => 'Pendiente',
                'fecha_entrega' => $datos['fecha_entrega'],
                'observaciones' => $datos['observaciones'],
            ]);

            foreach ($datos['detalles'] as $d) {
                OrdenDetalle::create([
                    'id_detalle_orden' => (OrdenDetalle::max('id_detalle_orden') ?? 0) + 1,
                    'id_orden'         => $idOrden,
                    'id_alimento'      => $d['id_alimento'],
                    'cantidad'         => $d['cantidad'],
                ]);
            }
            return $orden;
        });

        return $this->ok('Registro creado correctamente.',
            new ClientOrdenResource($orden->load('detalles.alimento')), 201);
    }

    public function show($id)
    {
        $orden = Orden::with('detalles.alimento')->findOrFail($id);   
        Gate::authorize('manage-own-resource', $orden);                

        return $this->ok('Registro encontrado.', new ClientOrdenResource($orden));
    }

    public function update(ClientResourceRequest $request, $id)
    {
        $orden = Orden::findOrFail($id);
        Gate::authorize('update', $orden);

        $orden->update($request->validated());

        return $this->ok('Registro actualizado correctamente.',
            new ClientOrdenResource($orden->fresh()->load('detalles.alimento')));
    }

    public function destroy($id)
    {
        $orden = Orden::findOrFail($id);
        Gate::authorize('delete', $orden);   

        
        $orden->update(['estado' => 'Cancelada']);

        return $this->ok('Registro cancelado correctamente.');
    }
}