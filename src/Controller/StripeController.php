<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Stripe\Stripe;
use Stripe\PaymentIntent; 
use Symfony\Component\HttpFoundation\Request;

class StripeController extends AbstractController {

    public function __construct()
    {
        Stripe::setApiKey($_ENV['STRIPE_SECRET']);
    }

    #[Route('/stripe/create-payment', name: 'app_stripe_create_payment', methods: ['POST'])]
    public function createCharge(Request $request): JsonResponse
    { 
        $data = json_decode($request->getContent(), true); 

        if (!isset($data['amount'])) {
            return new JsonResponse(['error' => 'No amount'], 400);
        }
        
        $paymentIntent = PaymentIntent::create([
            'amount' => $data['amount'], 
            'currency' => $data['currency']
        ]); 

        return new JsonResponse(['clientSecret' => $paymentIntent->client_secret]);
    }

    #[Route('/payment_success', name:'payment_success', methods: ['POST'])]
    public function paymentSuccess(Request $request): JsonResponse
    {
        $paymentIntentId = $request->getContent('payment_intent'); 
        $paymentIntent = PaymentIntent::retrieve($paymentIntentId); 

        if ($paymentIntent->status === 'succeeded') {
            return new JsonResponse(['message' => 'Paiement réussi', 'amount' => $paymentIntent]); 
        }
        return new JsonResponse(['message' => 'La paiement n\'a pas été confirmé'], 400); 
    }
}
