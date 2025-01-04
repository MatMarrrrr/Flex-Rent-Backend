<?php

namespace App\Services;

use App\Contracts\Repositories\RentalRepositoryInterface;
use App\Contracts\Repositories\RequestRepositoryInterface;
use App\Contracts\Services\RentalServiceInterface;
use App\Contracts\Services\RequestServiceInterface;
use App\Enums\RequestStatus;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use App\Models\Request;
use Symfony\Component\HttpFoundation\Response;

class RequestService implements RequestServiceInterface
{
    private RequestRepositoryInterface $requestRepository;
    private RentalRepositoryInterface $rentalRepository;

    public function __construct(RequestRepositoryInterface $requestRepository, RentalRepositoryInterface $rentalRepository)
    {
        $this->requestRepository = $requestRepository;
        $this->rentalRepository = $rentalRepository;
    }

    public function createRequest(array $data): JsonResponse
    {
        if ($data['sender_id'] === $data['recipient_id']) {
            return response()->json([
                'error' => 'You cannot send a request to yourself.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $existingRequest = Request::where([
            'sender_id' => $data['sender_id'],
            'recipient_id' => $data['recipient_id'],
            'listing_id' => $data['listing_id'],
        ])
            ->whereIn('status', ['waiting', 'accepted'])
            ->first();

        if ($existingRequest) {
            return response()->json([
                'error' => 'Request has already been sent for this listing.'
            ], Response::HTTP_CONFLICT);
        }

        $request = Request::create([
            'sender_id' => $data['sender_id'],
            'recipient_id' => $data['recipient_id'],
            'listing_id' => $data['listing_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => RequestStatus::WAITING->value,
        ]);

        return response()->json([
            'message' => 'Request created successfully.',
            'data' => $request
        ], Response::HTTP_CREATED);
    }

    public function getIncomingRequests(int $userId): JsonResponse
    {
        $requests = $this->requestRepository->getIncoming($userId);
        return response()->json(['requests' => $requests], Response::HTTP_OK);
    }

    public function getOutgoingRequests(int $userId): JsonResponse
    {
        $requests = $this->requestRepository->getOutgoing($userId);
        return response()->json(['requests' => $requests], Response::HTTP_OK);
    }

    public function acceptRequest(int $requestId, int $userId): JsonResponse
    {
        $request = $this->requestRepository->findRequestById($requestId);

        if (!$request) {
            return response()->json(['error' => 'Request not found'], Response::HTTP_NOT_FOUND);
        }

        if ($request->recipient_id !== $userId) {
            return response()->json(['error' => 'You are not authorized to accept this request'], Response::HTTP_FORBIDDEN);
        }

        $this->requestRepository->updateRequestStatus($requestId, RequestStatus::ACCEPTED->value);

        return response()->json(['message' => 'Request accepted successfully'], Response::HTTP_OK);
    }

    public function declineRequest(int $requestId, int $userId): JsonResponse
    {
        $request = $this->requestRepository->findRequestById($requestId);

        if (!$request) {
            return response()->json(['error' => 'Request not found'], Response::HTTP_NOT_FOUND);
        }

        if ($request->recipient_id !== $userId) {
            return response()->json(['error' => 'You are not authorized to decline this request'], Response::HTTP_FORBIDDEN);
        }

        $this->requestRepository->updateRequestStatus($requestId, RequestStatus::DECLINED->value);

        return response()->json(['message' => 'Request declined successfully'], Response::HTTP_OK);
    }

    public function confirmRequest(int $requestId, int $userId): JsonResponse
    {
        $request = $this->requestRepository->findRequestById($requestId);

        if (!$request) {
            return response()->json(['error' => 'Request not found'], Response::HTTP_NOT_FOUND);
        }

        if ($request->recipient_id !== $userId) {
            return response()->json(['error' => 'You are not authorized to confirm this request'], Response::HTTP_FORBIDDEN);
        }

        $this->requestRepository->updateRequestStatus($requestId, RequestStatus::CONFIRMED->value);
        $this->rentalRepository->create([
            "listing_id" => $request->listing_id,
            "request_id" => $request->id,
            "owner_id" => $request->recipient_id,
            "borrower_id" => $request->sender_id,
        ]);
        return response()->json(['message' => 'Request confirmed successfully'], Response::HTTP_OK);
    }

    public function cancelRequest(int $requestId, int $userId): JsonResponse
    {
        $request = $this->requestRepository->findRequestById($requestId);

        if (!$request) {
            return response()->json(['error' => 'Request not found'], Response::HTTP_NOT_FOUND);
        }

        if ($request->sender_id !== $userId) {
            return response()->json(['error' => 'You are not authorized to cancel this request'], Response::HTTP_FORBIDDEN);
        }

        $this->requestRepository->updateRequestStatus($requestId, RequestStatus::CANCELED->value);

        return response()->json(['message' => 'Request canceled successfully'], Response::HTTP_OK);
    }

    public function updateRequestPeriod(int $requestId, int $userId, array $period): JsonResponse
    {
        $request = $this->requestRepository->findRequestById($requestId);

        if (!$request) {
            return response()->json(['error' => 'Request not found'], Response::HTTP_NOT_FOUND);
        }

        if ($request->sender_id !== $userId) {
            return response()->json(['error' => 'You are not authorized to update the period for this request'], Response::HTTP_FORBIDDEN);
        }

        $startDate = $period['start_date'];
        $endDate = $period['end_date'];

        if ($startDate >= $endDate) {
            return response()->json(['error' => 'Start date must be before end date'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $updated = $this->requestRepository->updateRequestPeriod($requestId, $startDate, $endDate);

        if (!$updated) {
            return response()->json(['error' => 'Request period update failed'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'Request period updated successfully'], Response::HTTP_OK);
    }

    public function checkRequestExists(array $data): JsonResponse
    {
        $request = Request::where([
            'sender_id' => $data['sender_id'],
            'recipient_id' => $data['recipient_id'],
            'listing_id' => $data['listing_id'],
        ])
            ->whereIn('status', ['waiting', 'accepted'])
            ->first();

        if ($request) {
            return response()->json([
                'request' => $request
            ], Response::HTTP_OK);
        }

        return response()->json([
            'error' => 'Request not found'
        ], Response::HTTP_NOT_FOUND);
    }
}
