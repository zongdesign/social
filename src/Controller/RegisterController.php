<?php

namespace App\Controller;

use App\DTO\SignUp;
use App\Entity\User;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use SocialTech\SlowStorage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RegisterController.
 */
class RegisterController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var ValidatorInterface
     */
    private $validation;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validation, SerializerInterface $serializer, SlowStorage $storage)
    {
        $this->entityManager = $entityManager;
        $this->validation = $validation;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/api/register", name="api_register")
     */
    public function register(Request $request)
    {
        try {
            $signUpDto = $this->createSignUpDto($request);
            $errors = $this->validation->validate($signUpDto);

            if (count($errors)) {
                throw new \Exception($this->handleValidationResult($errors));
            }

            $user = $this->createUser($signUpDto);

        } catch (\Throwable $exception) {
            return $this->json(['Error' => $exception->getMessage()], 400);
        }

        return $this->json($user, 200, [], [
            'groups' => ['main'],
        ]);
    }

    /**
     * @param SignUp $signUpDto
     *
     * @return User
     *
     * @throws \Exception
     */
    private function createUser(SignUp $signUpDto): User
    {
        try {
            $user = (new User())
                ->setNickname($signUpDto->getNickname())
                ->setFirstname($signUpDto->getFirstname())
                ->setLastname($signUpDto->getLastname())
                ->setAge((int) $signUpDto->getAge())
                ->setPassword($signUpDto->getPassword())
            ;

            $this->entityManager->persist($user);
            $this->entityManager->flush();

        } catch (UniqueConstraintViolationException $exception) {
                throw new \Exception(
                    sprintf('We can not create user with nickname %s. Try to use unique nickname.', $user->getNickname())
                );
        }

        return $user;
    }

    /**
     * @param Request $request
     *
     * @return SignUp
     */
    private function createSignUpDto(Request $request): SignUp
    {
        return new SignUp(
            $request->get('nickname') ?? '',
            $request->get('firstname')?? '',
            $request->get('lastname')?? '',
            (int) $request->get('age')?? '',
            $request->get('password')?? ''
        );
    }

    /**
     * @param $errors
     *
     * @return string
     */
    private function handleValidationResult($errors): string
    {
        $errorMessage = [];

        foreach ($errors as $error){
            /** @var ConstraintViolation $error */
            $errorMessage[] = sprintf(
                'Field: %s. %s',
                $error->getPropertyPath(),
                $error->getMessage()
            );
        }

        return implode(' ', $errorMessage);
    }
}
