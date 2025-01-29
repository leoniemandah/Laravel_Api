<?php

namespace Tests\Unit;

use App\Infrastructure\Profile\Services\ProfileService;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use RuntimeException;
use App\Domain\Profile\Repositories\ProfileRepositoryInterface;
use Tests\TestCase;

class ProfileServiceTest extends TestCase
{

    protected $profileService;
    protected $filesystem;
    protected $profileRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock du repository
        $this->profileRepository = $this->createMock(ProfileRepositoryInterface::class);

        // Mock du filesystem
        $this->filesystem = $this->createMock(Filesystem::class);

        // Instanciation du service avec le repository mocké et le filesystem m<ocké
        $this->profileService = new ProfileService($this->profileRepository, $this->filesystem);
    }

    /** @test */
    public function it_stores_an_image_and_returns_file_name()
    {
        // On simule une image uploadée
        $file = UploadedFile::fake()->image('test.jpg');

        // Mock pour la méthode putFileAs de Filesystem
        $this->filesystem
            ->expects($this->once())
            ->method('putFileAs')
            ->with('profiles', $file, $this->anything());

        $fileName = $this->profileService->storeImage($file);

        // Vérifie que le nom de fichier contient une extension jpg
        $this->assertStringEndsWith('.jpg', $fileName);
    }

    /** @test */
    public function it_throws_exception_when_image_cannot_be_stored()
    {
        // Simule une image uploadée
        $file = UploadedFile::fake()->image('test.jpg');

        // Mock pour forcer une exception lors de l'appel à putFileAs
        $this->filesystem
            ->expects($this->once())
            ->method('putFileAs')
            ->willThrowException(new \Exception('Erreur d\'enregistrement'));

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('L\'image n\'a pas pu être enregistrée.');

        $this->profileService->storeImage($file);
    }
}
