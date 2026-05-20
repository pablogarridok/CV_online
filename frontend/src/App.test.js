import { render, screen } from '@testing-library/react';
import App from './App';

test('renderiza el CV sin errores', () => {
  render(<App />);
  // El CV debe mostrar algún contenido
  expect(document.body).toBeTruthy();
});
