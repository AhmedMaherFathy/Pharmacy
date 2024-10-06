<?php

namespace Modules\Auth\Http\Controllers;

use App\Traits\HttpResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Auth\Actions\Register\ClientRegisterAction;
use Modules\Auth\Actions\Register\StoreRegisterAction;
use Modules\Auth\Http\Requests\Register\ClientRegisterRequest;
use Modules\Auth\Http\Requests\Register\StoreRegisterRequest;
use Modules\Auth\Strategies\Verifiable;

class RegisterController extends Controller
{
    use HttpResponse;

    private Verifiable $verifiable;

    public function __construct(Verifiable $verifiable)
    {
        $this->verifiable = $verifiable;
    }

    public function client(ClientRegisterRequest $request, ClientRegisterAction $registerService): JsonResponse
    {
        $registerService->handle($request->validated(), $this->verifiable);

        return $this->baseReturn();
    }

    public function store(StoreRegisterRequest $request, StoreRegisterAction $storeRegisterAction)
    {
        $storeRegisterAction->handle($request->validated());

        return $this->baseReturn();
    }

    private function baseReturn(): JsonResponse
    {
        return $this->createdResponse(
            message: translate_success_message('user', 'created')
            .' '.translate_word('user_verification_sent')
        );
    }
}