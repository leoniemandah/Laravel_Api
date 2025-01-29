<?php

namespace App\Infrastructure\Profile\Services;

use Illuminate\Contracts\Filesystem\Filesystem;
use App\Domain\Profile\Dtos\ProfileDTO;
use App\Domain\Profile\Models\Profile;
use App\Domain\Profile\Repositories\ProfileRepositoryInterface;
use App\Domain\Profile\Services\ProfileServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProfileService implements ProfileServiceInterface
{
    protected ProfileRepositoryInterface $profileRepository;

    protected Filesystem $storage;

    public function __construct(ProfileRepositoryInterface $profileRepository, Filesystem $storage)
    {
        $this->profileRepository = $profileRepository;
        $this->storage = $storage;

    }

    public function getAllProfile(Request $request): LengthAwarePaginator
    {
        return $this->profileRepository->findAll($request);
    }

    public function createProfile(ProfileDTO $profileDTO, UploadedFile $image): Profile
    {
        $imageName = $this->storeImage($image);
        return $this->profileRepository->create($profileDTO, $imageName);
    }

    public function updateProfile(ProfileDTO $profileDTO, string $id, ?UploadedFile $image): Profile
    {
        // Récupérer le profil à modifier
        $profile = $this->profileRepository->findById($id);

        if (!$profil) {
            throw new NotFoundHttpException("Aucun profil existant pour cet id.");
        }

        if ($image) {
            $imageName = $this->storeImage($image);
        }
        return $this->profileRepository->update($profileDTO, $profile, $imageName ?? null);
    }

    public function getProfileById(string $id): Profile
    {
        // Récupérer le profil par ID
        $profile = $this->profileRepository->findById($id);

        if (!$profile) {
            throw new NotFoundHttpException("Aucun profil existant pour cet id.");
        }

        return $profile;
    }

    public function deleteProfile(string $id): bool
    {
        // Vérifier si le profil existe avant de supprimer
        $profile = $this->profileRepository->findById($id);

        if (!$profile) {
            throw new NotFoundHttpException("Aucun profil existant pour cet id.");
        }

        return $this->profileRepository->delete($profile);
    }

    public function storeImage(UploadedFile $image): string
    {
        $imageName = $this->generateImageName($image);

        try {
            $this->storage->putFileAs('profiles', $image, $imageName);
        } catch (\Exception $e) {
            throw new \RuntimeException('L\'image n\'a pas pu être enregistrée.');
        }

        return $imageName;
    }

    private function generateImageName(UploadedFile $image): string
    {
        return uniqid() . '.' . $image->getClientOriginalExtension();
    }
}
