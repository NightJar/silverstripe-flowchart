<?php

namespace ChTombleson\Flowchart\Controllers;

use ChTombleson\Flowchart\Models\Flowchart;
use ChTombleson\Flowchart\Models\FlowchartFeedback;
use ChTombleson\Flowchart\Models\FlowchartVote;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Security\SecurityToken;

class FlowchartController extends Controller
{
    /**
     * @var array
     */
    private static $allowed_actions = [
        'Form',
    ];

    /**
     * @return HTTPResponse
     */
    public function form()
    {
        $request = $this->getRequest();

        $response = HTTPResponse::create();
        $response->addHeader('Content-Type', 'application/json');

        if (!$request->isAjax() || !$request->isPost()) {
            $response->setStatusCode(200);
            $response->setBody(json_encode(['error' => 'Unable to submit form.']));

            return $response;
        }

        $token = $request->postVar('token');
        $id = (int) $request->postVar('id');
        $vote = $request->postVar('vote');
        $feedback = $request->postVar('feedback');
        $ip = $request->getIP();

        $securityToken = SecurityToken::create('Flowchart_' . $id);

        if ($securityToken->check($token)) {
            $flowchart = Flowchart::get()->byId($id);

            if ($flowchart) {
                if (!empty($feedback)) {
                    $feedbackObj = new FlowchartFeedback();
                    $feedbackObj->IP = $ip;
                    $feedbackObj->Feedback = $feedback;
                    $feedbackObj->FlowchartID = $id;
                    $feedbackObj->write();
                }

                if (!empty($vote)) {
                    $voteObj = new FlowchartVote();
                    $voteObj->IP = $ip;
                    $voteObj->Value = $vote;
                    $voteObj->FlowchartID = $id;
                    $voteObj->write();
                }

                $response->setStatusCode(200);
                $response->setBody(json_encode(['message' => 'Thank you for the feedback.']));

                return $response;
            }
        }

        $response->setStatusCode(200);
        $response->setBody(json_encode(['error' => 'Unable to submit form.']));

        return $response;
    }
}
