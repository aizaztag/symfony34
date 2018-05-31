<?php

// src/AppBundle/Controller/GitHutController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GithubController extends Controller
{
    /**
     * @Route("/github/{username}", name="github" , defaults={"username":"codereviewvideos"})
     */
    public function githutAction(Request $request , $username)
    {

        $templateData = [
            'username' => $username,
            'repo_count' => 100,
            'most_stars' => 50,
            'repos' => [
                [
                    'url' => 'https://codereviewvideos.com',
                    'name' => 'Code Review Videos',
                    'description' => 'some repo description',
                    'stargazers_count' => '999',
                ],
                [
                    'url' => 'http://bbc.co.uk',
                    'name' => 'The BBC',
                    'description' => 'not a real repo',
                    'stargazers_count' => '666',
                ],
                [
                    'url' => 'http://google.co.uk',
                    'name' => 'Google',
                    'description' => 'another fake repo description',
                    'stargazers_count' => '333',
                ],
            ],

        ];


        return $this->render('github/index.html.twig',$templateData);
    }

    /**
     * @Route("/profile/{username}", name="profile")
     */
    public function profileAction(Request $request ,$username)
    {
        dump($username);
        $api = $this->get('github_api')->getProfile($username);

        return $this->render('github/profile.html.twig', $api);
    }
}
