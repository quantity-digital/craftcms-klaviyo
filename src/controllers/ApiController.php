<?php

namespace QD\klaviyo\controllers;

use craft\web\Controller;
use QD\klaviyo\config\Response;
use QD\klaviyo\domains\events\EventsQueue;
use QD\klaviyo\domains\order\OrderQueue;
use QD\klaviyo\domains\profiles\ProfilesRepository;
use craft\commerce\Plugin as Commerce;

class ApiController extends Controller
{
    protected array|bool|int $allowAnonymous = [
        'subscribe' => self::ALLOW_ANONYMOUS_LIVE | self::ALLOW_ANONYMOUS_OFFLINE,
        'track-event' => self::ALLOW_ANONYMOUS_LIVE | self::ALLOW_ANONYMOUS_OFFLINE,
        'track-order' => self::ALLOW_ANONYMOUS_LIVE | self::ALLOW_ANONYMOUS_OFFLINE,
    ];

    public function actionSubscribe()
    {
        //* Require
        $this->requirePostRequest();

        //* Query params
        $list = $this->request->getBodyParam('list') ?? null;
        $email = $this->request->getRequiredBodyParam('email');
        $attributes = $this->request->getBodyParam('attributes') ?? $this->request->getBodyParam('att') ?? null;
        $properties = $this->request->getBodyParam('properties') ?? $this->request->getBodyParam('prop') ?? null;

        //* Profile
        $profile = ProfilesRepository::createProfileAndSubscribeToList($email, $list, $attributes, $properties);

        //* Response
        return $this->asJson(Response::success($profile));
    }

    public function actionTrackEvent()
    {
        //* Require
        $this->requirePostRequest();

        //* Params
        $name = $this->request->getRequiredBodyParam('name');
        $email = $this->request->getRequiredBodyParam('email');
        $properties = $this->request->getRequiredBodyParam('properties');

        //* Create event
        EventsQueue::createEvent($name, $email, $properties);

        //* Response
        return $this->asJson(Response::success(''));
    }

    public function actionTrackOrder()
    {
        //* Require
        $this->requirePostRequest();

        //* Params
        $name = $this->request->getRequiredBodyParam('name');
        $email = $this->request->getRequiredBodyParam('email');
        $orderId = $this->request->getBodyParam('orderId') ?? Commerce::getInstance()->getCarts()->getCart()->id ?? null;
        $properties = $this->request->getBodyParam('properties') ?? null;

        //* Create event
        OrderQueue::createEvent($name, $email, $orderId, $properties);

        //* Response
        return $this->asJson(Response::success('Order tracked'));
    }
}
